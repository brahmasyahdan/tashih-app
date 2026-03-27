<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peserta;
use App\Models\Lembaga;
use App\Models\Materi;
use App\Helpers\TashihHelper;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index()
    {
        $lembaga = Lembaga::where('is_active', true)->orderBy('nama_lembaga')->get();
        return view('admin.laporan.index', compact('lembaga'));
    }

    // Kartu Nilai Individual
    public function kartuNilai($pesertaId)
    {
        $peserta = Peserta::with(['lembaga', 'sertifikat'])->findOrFail($pesertaId);
        
        $materi = Materi::where('is_active', true)
            ->with(['itemMateri' => fn($q) => $q->where('is_active', true)->orderBy('urutan')])
            ->orderBy('urutan')
            ->get();

        $nilaiData = [];
        foreach ($materi as $m) {
            $nilaiData[$m->id] = [];
            foreach ($m->itemMateri as $item) {
                $nilai = $peserta->nilai()
                    ->where('item_materi_id', $item->id)
                    ->first();
                $nilaiData[$m->id][$item->id] = $nilai;
            }
        }

        $pdf = Pdf::loadView('admin.laporan.kartu-nilai', compact('peserta', 'materi', 'nilaiData'))
                  ->setPaper('a4', 'portrait');

        return $pdf->stream('Kartu_Nilai_' . $peserta->nama_peserta . '.pdf');
    }

    // Rekap Per Lembaga
    public function rekapLembaga(Request $request)
    {
        $request->validate(['lembaga_id' => 'required|exists:lembaga,id']);

        $lembaga = Lembaga::findOrFail($request->lembaga_id);
        $peserta = Peserta::where('lembaga_id', $lembaga->id)
            ->with('sertifikat')
            ->orderBy('nama_peserta')
            ->get();

        $materi = Materi::where('is_active', true)->orderBy('urutan')->get();

        // Hitung rata-rata lembaga
        $totalNilai = 0;
        $jumlahLengkap = 0;
        foreach ($peserta as $p) {
            if ($p->status_nilai === 'lengkap' && $p->nilai_akhir) {
                $totalNilai += $p->nilai_akhir;
                $jumlahLengkap++;
            }
        }
        $rataRata = $jumlahLengkap > 0 ? $totalNilai / $jumlahLengkap : 0;

        $pdf = Pdf::loadView('admin.laporan.rekap-lembaga', compact('lembaga', 'peserta', 'materi', 'rataRata'))
                  ->setPaper('a4', 'landscape');

        return $pdf->stream('Rekap_Nilai_' . $lembaga->nama_lembaga . '.pdf');
    }

    // Rekap Keseluruhan (Semua Lembaga)
    public function rekapKeseluruhan()
    {
        $lembagaList = Lembaga::where('is_active', true)
            ->with(['peserta' => fn($q) => $q->orderBy('nama_peserta')])
            ->orderBy('nama_lembaga')
            ->get();

        $materi = Materi::where('is_active', true)->orderBy('urutan')->get();

        // Statistik global
        $totalPeserta = Peserta::count();
        $totalLengkap = Peserta::where('status_nilai', 'lengkap')->count();
        $nilaiSum = Peserta::where('status_nilai', 'lengkap')->sum('nilai_akhir');
        $rataRataGlobal = $totalLengkap > 0 ? $nilaiSum / $totalLengkap : 0;

        $distribusiPredikat = [
            'Mumtaz' => Peserta::where('predikat', 'Mumtaz')->count(),
            'Jayyid Jiddan' => Peserta::where('predikat', 'Jayyid Jiddan')->count(),
            'Jayyid' => Peserta::where('predikat', 'Jayyid')->count(),
            'Maqbul' => Peserta::where('predikat', 'Maqbul')->count(),
            'Dhaif' => Peserta::where('predikat', 'Dhaif')->count(),
        ];

        $pdf = Pdf::loadView('admin.laporan.rekap-keseluruhan', compact(
            'lembagaList', 'materi', 'totalPeserta', 'totalLengkap', 
            'rataRataGlobal', 'distribusiPredikat'
        ))->setPaper('a4', 'landscape');

        return $pdf->stream('Rekap_Keseluruhan_' . date('Y-m-d') . '.pdf');
    }
}