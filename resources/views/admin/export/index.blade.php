@extends('layouts.app')
@section('title', 'Export Excel')
@section('page-title', 'Export Data ke Excel')

@section('content')
<div class="max-w-2xl">
    <div class="card">
        <div class="flex items-center gap-4 mb-6">
            <div class="w-14 h-14 bg-green-100 rounded-xl flex items-center justify-center">
                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <div>
                <h3 class="font-bold text-hijau-700 text-lg">Export Data Peserta ke Excel</h3>
                <p class="text-sm text-gray-500">Unduh data peserta beserta nilai dalam format .xlsx</p>
            </div>
        </div>

        <form action="{{ route('admin.export.excel') }}" method="POST">
            @csrf

            <div class="bg-hijau-50 border border-hijau-200 rounded-lg p-4 mb-4">
                <p class="text-sm text-hijau-800 font-medium mb-2">📋 Data yang akan di-export:</p>
                <ul class="text-sm text-hijau-700 space-y-1 ml-4 list-disc">
                    <li>Identitas peserta (Nama, NIS, Lembaga, Tahun)</li>
                    <li>Nilai per materi dalam persentase</li>
                    <li>Nilai akhir & predikat</li>
                    <li>Nomor sertifikat & status</li>
                </ul>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Filter Lembaga (Opsional)</label>
                <select name="lembaga_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-hijau-500">
                    <option value="">📊 Semua Lembaga</option>
                    @foreach($lembaga as $l)
                        <option value="{{ $l->id }}">{{ $l->nama_lembaga }}</option>
                    @endforeach
                </select>
                <p class="text-xs text-gray-400 mt-1">Kosongkan untuk export semua data dari seluruh lembaga</p>
            </div>

            <button type="submit" class="btn-primary w-full flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
                Download Excel (.xlsx)
            </button>
        </form>
    </div>
</div>
@endsection