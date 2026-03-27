<?php

namespace App\Http\Controllers\Penguji;

use App\Http\Controllers\Controller;
use App\Models\Peserta;
use App\Models\Materi;
use App\Models\Nilai;
use App\Models\Sertifikat;
use App\Helpers\TashihHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NilaiController extends Controller
{
    public function index(Request $request)
    {
        $query = Peserta::with('lembaga')->latest();

        // Filter pencarian by nama peserta
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('nama_peserta', 'like', '%' . $request->search . '%')
                ->orWhere('nis', 'like', '%' . $request->search . '%');
            });
        }

        // Filter by lembaga
        if ($request->filled('lembaga_id')) {
            $query->where('lembaga_id', $request->lembaga_id);
        }

        // Filter by tahun ujian
        if ($request->filled('tahun_ujian')) {
            $query->where('tahun_ujian', $request->tahun_ujian);
        }

        $peserta = $query->paginate(15)->withQueryString();

        // Data untuk dropdown filter
        $lembaga = \App\Models\Lembaga::orderBy('nama_lembaga')->get();
        
        $tahunList = Peserta::distinct()
                            ->pluck('tahun_ujian')
                            ->sort()
                            ->values();

        return view('penguji.nilai.index', compact('peserta', 'lembaga', 'tahunList'));
    }

    public function show(Peserta $peserta)
    {
        $penggujiId = Auth::id();
        
        // Ambil hanya materi yang ditugaskan ke penguji ini
        $materiDitugaskan = Auth::user()->materiYangDiuji->pluck('id')->toArray();
        
        if (empty($materiDitugaskan)) {
            return redirect()->route('penguji.nilai.index')
                            ->with('error', 'Anda belum ditugaskan ke materi apapun. Silakan hubungi admin.');
        }
        
        $materi = Materi::whereIn('id', $materiDitugaskan)
                        ->where('is_active', true)
                        ->with(['itemMateri' => fn($q) => $q->where('is_active', true)->orderBy('urutan')])
                        ->orderBy('urutan')
                        ->get();

        $nilaiData = Nilai::where('peserta_id', $peserta->id)
                        ->where('penguji_id', $penggujiId)
                        ->get()
                        ->keyBy('item_materi_id');

        return view('penguji.nilai.show', compact('peserta', 'materi', 'nilaiData'));
    }

    public function store(Request $request, Peserta $peserta)
    {
        $request->validate([
            'nilai'          => 'required|array',
            'nilai.*'        => 'nullable|numeric|min:0|max:100',
            'catatan'        => 'nullable|array',
            'materi_id'      => 'required|array',
            'item_materi_id' => 'required|array',
        ]);

        // Cek apakah penguji sudah pernah finalisasi nilai untuk peserta ini
        $sudahFinal = Nilai::where('peserta_id', $peserta->id)
                        ->where('penguji_id', Auth::id())
                        ->where('is_final', true)
                        ->exists();

        if ($sudahFinal) {
            return redirect()->route('penguji.nilai.show', $peserta)
                            ->with('error', 'Anda sudah menyelesaikan penilaian untuk peserta ini. Tidak bisa mengubah nilai lagi.');
        }

        foreach ($request->nilai as $itemId => $nilaiValue) {
            if ($nilaiValue === null) continue;

            Nilai::updateOrCreate(
                [
                    'peserta_id'    => $peserta->id,
                    'item_materi_id'=> $itemId,
                    'penguji_id'    => Auth::id(),
                ],
                [
                    'materi_id' => $request->materi_id[$itemId],
                    'nilai'     => $nilaiValue,
                    'catatan'   => $request->catatan[$itemId] ?? null,
                    'is_final'  => true,
                ]
            );
        }

        // Hitung ulang nilai akhir & predikat
        $nilaiAkhir = \App\Helpers\TashihHelper::hitungNilaiAkhir($peserta->id);
        $predikat   = \App\Helpers\TashihHelper::getPredikat($nilaiAkhir);

        // Hitung status penilaian - GUNAKAN HELPER BARU
        $statusInfo = \App\Helpers\TashihHelper::hitungStatusNilai($peserta->id);

        $peserta->update([
            'nilai_akhir'  => $nilaiAkhir,
            'predikat'     => $predikat,
            'status_nilai' => $statusInfo['status'], // Gunakan status dari helper
        ]);

        // Generate sertifikat jika sudah lengkap
        if ($statusInfo['status'] === 'lengkap' && !$peserta->sertifikat) {
            $nomorSertifikat = \App\Helpers\TashihHelper::generateNomorSertifikat(
                $peserta->lembaga->kode_lembaga,
                $peserta->tahun_ujian
            );

            \App\Models\Sertifikat::create([
                'peserta_id'       => $peserta->id,
                'nomor_sertifikat' => $nomorSertifikat,
                'tanggal_terbit'   => now()->toDateString(),
            ]);
        }

        // Log aktivitas
        \App\Helpers\TashihHelper::logActivity(
            'Input Nilai',
            "Menginput nilai untuk peserta: {$peserta->nama_peserta} (ID: {$peserta->id})"
        );

        return redirect()->route('penguji.nilai.index')
                        ->with('success', 'Nilai berhasil disimpan dan telah difinalisasi! Anda tidak bisa mengubahnya lagi.');
    }
}