<?php

namespace App\Http\Controllers\Lembaga;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Exports\PesertaExport;
use App\Imports\PesertaImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;

class ImportExportController extends Controller
{
    public function index()
    {
        return view('lembaga.import-export.index');
    }

    public function export()
    {
        $lembagaId = Auth::user()->lembaga_id;

        if (!$lembagaId) {
            return redirect()->back()->with('error', 'Anda belum terdaftar di lembaga manapun.');
        }

        $filename = 'Data_Peserta_' . date('YmdHis') . '.xlsx';

        return Excel::download(new PesertaExport($lembagaId), $filename);
    }

    public function downloadTemplate()
    {
        $filePath = public_path('templates/Template_Import_Peserta.xlsx');

        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'Template tidak ditemukan.');
        }

        return response()->download($filePath);
    }

    public function import(Request $request)
    {
        $lembagaId = Auth::user()->lembaga_id;

        if (!$lembagaId) {
            return redirect()->back()->with('error', 'Anda belum terdaftar di lembaga manapun.');
        }

        $request->validate([
            'file' => 'required|mimes:xlsx,xls|max:2048',
        ]);

        try {
            Excel::import(new PesertaImport($lembagaId), $request->file('file'));

            \App\Helpers\TashihHelper::logActivity('Import Peserta', 'Berhasil import data peserta dari Excel');

            return redirect()->back()->with('success', 'Data peserta berhasil diimport!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Import gagal: ' . $e->getMessage());
        }
    }
}