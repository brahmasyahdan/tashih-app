<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peserta;
use App\Models\Materi;
use App\Models\Nilai;
use App\Models\Sertifikat;
use App\Helpers\TashihHelper;
use Illuminate\Http\Request;

class NilaiEditController extends Controller
{
    public function edit(Peserta $peserta)
    {
        $materi = Materi::where('is_active', true)
                        ->with(['itemMateri' => fn($q) => $q->where('is_active', true)->orderBy('urutan')])
                        ->orderBy('urutan')
                        ->get();

        $nilaiData = Nilai::where('peserta_id', $peserta->id)
                          ->get()
                          ->keyBy('item_materi_id');

        return view('admin.nilai.edit', compact('peserta', 'materi', 'nilaiData'));
    }

    public function update(Request $request, Peserta $peserta)
    {
        $request->validate([
            'nilai'          => 'required|array',
            'nilai.*'        => 'nullable|numeric|min:0|max:100',
            'catatan'        => 'nullable|array',
            'materi_id'      => 'required|array',
            'item_materi_id' => 'required|array',
            'penguji_id'     => 'required|array',
        ]);

        foreach ($request->nilai as $itemId => $nilaiValue) {
            if ($nilaiValue === null) continue;

            Nilai::updateOrCreate(
                [
                    'peserta_id'    => $peserta->id,
                    'item_materi_id'=> $itemId,
                ],
                [
                    'materi_id'       => $request->materi_id[$itemId],
                    'penguji_id'      => $request->penguji_id[$itemId],
                    'nilai'           => $nilaiValue,
                    'catatan'         => $request->catatan[$itemId] ?? null,
                    'is_final'        => true,
                    'edited_by_admin' => true,
                    'last_edited_at'  => now(),
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
            'Edit Nilai',
            "Mengedit nilai untuk peserta: {$peserta->nama_peserta} (ID: {$peserta->id})"
        );

        return redirect()->route('admin.nilai.show', $peserta)
                        ->with('success', 'Nilai berhasil diperbarui!');
    }
}