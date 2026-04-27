@extends('layouts.app')
@section('title', 'Import & Export Data')
@section('page-title', 'Import & Export Data Peserta')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        {{-- Card Export --}}
        <div class="card">
            <h3 class="text-lg font-bold text-hijau-700 mb-4">📥 Export Data Peserta</h3>
            <p class="text-sm text-gray-600 mb-4">Download data peserta dalam format Excel (.xlsx)</p>

            <form action="{{ route('admin.export') }}" method="POST">
                @csrf
                <select name="lembaga_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg mb-3">
                    <option value="">Semua Lembaga</option>
                    @foreach(\App\Models\Lembaga::orderBy('nama_lembaga')->get() as $l)
                        <option value="{{ $l->id }}">{{ $l->nama_lembaga }}</option>
                    @endforeach
                </select>

                <button type="submit" class="btn-primary w-full">
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Download Excel
                </button>
            </form>
        </div>

        {{-- Card Import --}}
        <div class="card">
            <h3 class="text-lg font-bold text-hijau-700 mb-4">📤 Import Data Peserta</h3>
            <p class="text-sm text-gray-600 mb-4">Upload file Excel untuk menambah banyak peserta sekaligus</p>

            <form action="{{ route('admin.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="file" name="file" accept=".xlsx,.xls" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg mb-3">

                <button type="submit" class="btn-primary w-full mb-3">
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                    </svg>
                    Upload & Import
                </button>
            </form>

            <a href="{{ route('admin.download-template') }}" class="btn-outline w-full block text-center">
                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Download Template Excel
            </a>
        </div>
    </div>

    {{-- Panduan --}}
    <div class="card mt-6 bg-blue-50 border-blue-200">
        <h4 class="font-bold text-blue-800 mb-3">📋 Panduan Import Excel</h4>
        <ol class="list-decimal list-inside space-y-2 text-sm text-blue-700">
            <li>Download template Excel dengan klik tombol "Download Template"</li>
            <li>Isi data peserta sesuai kolom yang tersedia</li>
            <li>Kolom wajib: nama_peserta, jenis_kelamin, lembaga, tahun_ujian</li>
            <li>Jenis kelamin: L atau P</li>
            <li>Format tanggal lahir: YYYY-MM-DD (contoh: 2010-05-15)</li>
            <li>Upload file yang sudah diisi</li>
        </ol>
    </div>
@endsection