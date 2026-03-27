<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lembaga;
use App\Exports\PesertaExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    public function index()
    {
        $lembaga = Lembaga::where('is_active', true)->orderBy('nama_lembaga')->get();
        return view('admin.export.index', compact('lembaga'));
    }

    public function exportExcel(Request $request)
    {
        $lembagaId = $request->lembaga_id;
        
        $filename = $lembagaId 
            ? 'Data_Peserta_' . Lembaga::find($lembagaId)->kode_lembaga . '_' . date('Y-m-d') . '.xlsx'
            : 'Data_Peserta_Semua_' . date('Y-m-d') . '.xlsx';

        return Excel::download(new PesertaExport($lembagaId), $filename);
    }
}