<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peserta;
use App\Models\Materi;
use App\Models\Nilai;
use App\Helpers\TashihHelper;

class NilaiController extends Controller
{
    public function index()
    {
        $peserta = Peserta::with(['lembaga', 'sertifikat'])
                          ->latest()->paginate(15);
        return view('admin.nilai.index', compact('peserta'));
    }

    public function show(Peserta $peserta)
    {
        $materi = Materi::where('is_active', true)
                        ->with(['itemMateri' => fn($q) => $q->where('is_active', true)->orderBy('urutan')])
                        ->orderBy('urutan')
                        ->get();

        $nilaiData = Nilai::where('peserta_id', $peserta->id)
                          ->get()
                          ->keyBy('item_materi_id');

        return view('admin.nilai.show', compact('peserta', 'materi', 'nilaiData'));
    }
}