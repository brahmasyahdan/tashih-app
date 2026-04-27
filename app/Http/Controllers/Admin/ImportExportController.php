<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Exports\PesertaExport;
use App\Imports\PesertaImport;
use Maatwebsite\Excel\Facades\Excel;

class ImportExportController extends Controller
{
    public function index()
    {
        return view('admin.import-export.index');
    }

    public function export(Request $request)
    {
        $lembagaId = $request->lembaga_id;
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
        $request->validate([
            'file' => 'required|mimes:xlsx,xls|max:2048',
        ]);

        try {
            Excel::import(new PesertaImport(), $request->file('file'));

            \App\Helpers\TashihHelper::logActivity('Import Peserta', 'Berhasil import data peserta dari Excel');

            return redirect()->back()->with('success', 'Data peserta berhasil diimport!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Import gagal: ' . $e->getMessage());
        }
    }
}