<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth; // TAMBAHKAN INI
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class TashihHelper
{
    // Hitung predikat berdasarkan nilai akhir
    public static function getPredikat(float $nilai): string
    {
        if ($nilai >= 90) return 'Mumtaz';
        if ($nilai >= 80) return 'Jayyid Jiddan';
        if ($nilai >= 70) return 'Jayyid';
        if ($nilai >= 60) return 'Maqbul';
        return 'Dhaif';
    }

    // Keterangan predikat dalam bahasa Arab
    public static function getKeterangan(string $predikat): string
    {
        return match($predikat) {
            'Mumtaz'       => 'ممتاز — Istimewa',
            'Jayyid Jiddan'=> 'جيد جداً — Sangat Baik',
            'Jayyid'       => 'جيد — Baik',
            'Maqbul'       => 'مقبول — Cukup',
            'Dhaif'        => 'ضعيف — Kurang',
            default        => '-'
        };
    }

    // CSS class badge predikat
    public static function getBadgeClass(string $predikat): string
    {
        return match($predikat) {
            'Mumtaz'        => 'badge-mumtaz',
            'Jayyid Jiddan' => 'badge-jayyid-jiddan',
            'Jayyid'        => 'badge-jayyid',
            'Maqbul'        => 'badge-maqbul',
            'Dhaif'         => 'badge-dhaif',
            default         => 'bg-gray-100 text-gray-700 text-xs px-2 py-0.5 rounded-full'
        };
    }

    // Generate nomor sertifikat otomatis
    public static function generateNomorSertifikat(string $kodeLembaga, int $tahun): string
    {
        $prefix = "TASHIH-{$tahun}-{$kodeLembaga}";

        // Hitung berapa sertifikat sudah ada untuk lembaga & tahun ini
        $count = \App\Models\Sertifikat::whereHas('peserta', function($q) use ($kodeLembaga, $tahun) {
            $q->whereHas('lembaga', function($q2) use ($kodeLembaga) {
                $q2->where('kode_lembaga', $kodeLembaga);
            })->where('tahun_ujian', $tahun);
        })->count();

        $nomor = str_pad($count + 1, 4, '0', STR_PAD_LEFT);
        return "{$prefix}-{$nomor}";
    }

    // Hitung nilai akhir peserta dari semua nilai yang sudah diinput
    public static function hitungNilaiAkhir(int $pesertaId): float
    {
        // Cek dulu apakah semua item sudah dinilai
        $totalItem = \App\Models\ItemMateri::where('is_active', true)->count();
        $nilaiTerisi = \App\Models\Nilai::where('peserta_id', $pesertaId)->count();
        
        // Jika belum lengkap, return 0
        if ($nilaiTerisi < $totalItem) {
            return 0;
        }
        
        $materi = \App\Models\Materi::where('is_active', true)
                    ->with(['itemMateri' => function($q) {
                        $q->where('is_active', true);
                    }])
                    ->get();

        $totalBobot = 0;
        $nilaiTertimbang = 0;

        foreach ($materi as $m) {
            $items = $m->itemMateri;
            if ($items->isEmpty()) continue;

            $nilaiMateri = 0;
            $jumlahItem = 0;

            foreach ($items as $item) {
                $nilai = \App\Models\Nilai::where('peserta_id', $pesertaId)
                            ->where('item_materi_id', $item->id)
                            ->first();

                if ($nilai) {
                    $nilaiMateri += ($nilai->nilai / $item->nilai_max) * 100;
                    $jumlahItem++;
                }
            }

            if ($jumlahItem > 0) {
                $rataMateri = $nilaiMateri / $jumlahItem;
                $nilaiTertimbang += $rataMateri * ($m->bobot / 100);
                $totalBobot += $m->bobot;
            }
        }

        if ($totalBobot == 0) return 0;
        return round(($nilaiTertimbang / $totalBobot) * 100, 2);
    }

    // Hitung status penilaian peserta
    public static function hitungStatusNilai(int $pesertaId): array
    {
        $totalItem = \App\Models\ItemMateri::where('is_active', true)->count();
        $nilaiTerisi = \App\Models\Nilai::where('peserta_id', $pesertaId)->count();
        
        if ($nilaiTerisi == 0) {
            $status = 'belum_dinilai';
            $label = 'Belum Dinilai';
            $badgeClass = 'bg-gray-100 text-gray-700';
        } elseif ($nilaiTerisi < $totalItem) {
            $status = 'sedang_dinilai';
            $label = 'Sedang Dinilai';
            $badgeClass = 'bg-blue-100 text-blue-700';
        } else {
            $status = 'lengkap';
            $label = 'Lengkap';
            $badgeClass = 'bg-green-100 text-green-700';
        }
        
        return [
            'status' => $status,
            'label' => $label,
            'badge_class' => $badgeClass,
            'progress' => $totalItem > 0 ? round(($nilaiTerisi / $totalItem) * 100) : 0,
            'terisi' => $nilaiTerisi,
            'total' => $totalItem,
        ];
    }

    // Get detail item mana saja yang sudah/belum dinilai
    public static function getDetailPenilaian(int $pesertaId): array
    {
        $materi = \App\Models\Materi::where('is_active', true)
                    ->with(['itemMateri' => fn($q) => $q->where('is_active', true)])
                    ->orderBy('urutan')
                    ->get();
        
        $detail = [];
        
        foreach ($materi as $m) {
            $totalItem = $m->itemMateri->count();
            $terisi = \App\Models\Nilai::where('peserta_id', $pesertaId)
                        ->whereIn('item_materi_id', $m->itemMateri->pluck('id'))
                        ->count();
            
            $detail[] = [
                'materi' => $m->nama_materi,
                'terisi' => $terisi,
                'total' => $totalItem,
                'lengkap' => $terisi == $totalItem,
            ];
        }
        
        return $detail;
    }

    // Log aktivitas
    public static function logActivity(string $aksi, string $detail = null): void
    {
        try {
            if (!Auth::check()) {
                Log::warning('Log aktivitas gagal: User tidak login');
                return;
            }

            /** @var \App\Models\User $user */
            $user = Auth::user();
            
            // Debug: Log ke file Laravel
            Log::info('Mencoba log aktivitas', [
                'user_id' => $user->id,
                'nama' => $user->name,
                'aksi' => $aksi,
            ]);
            
            // Ambil role dengan aman
            $role = 'user';
            if (method_exists($user, 'getRoleNames')) {
                $roles = $user->getRoleNames();
                $role = $roles->isNotEmpty() ? $roles->first() : 'user';
            }

            $created = \App\Models\ActivityLog::create([
                'user_id'    => $user->id,
                'nama_user'  => $user->name,
                'role'       => $role,
                'aksi'       => $aksi,
                'detail'     => $detail,
                'ip_address' => request()->ip(),
            ]);
            
            // Debug: Konfirmasi berhasil
            Log::info('Log aktivitas berhasil disimpan', ['id' => $created->id]);
            
        } catch (\Exception $e) {
            // Log error ke file
            Log::error('Failed to log activity: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
        }
    }
}