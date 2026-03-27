@extends('layouts.app')
@section('title', 'Cetak Laporan')
@section('page-title', 'Cetak Laporan')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">

    {{-- Kartu Nilai Individual --}}
    <div class="card">
        <div class="w-12 h-12 bg-hijau-100 rounded-xl flex items-center justify-center mb-3">
            <svg class="w-6 h-6 text-hijau-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
        </div>
        <h3 class="font-bold text-hijau-700 mb-2">Kartu Nilai Individual</h3>
        <p class="text-sm text-gray-600 mb-4">Cetak kartu nilai per peserta dengan detail lengkap</p>
        <a href="{{ route('admin.peserta.index') }}" class="btn-primary text-sm block text-center">
            Pilih Peserta →
        </a>
        <p class="text-xs text-gray-400 mt-2">*Pilih dari halaman Data Peserta</p>
    </div>

    {{-- Rekap Per Lembaga --}}
    <div class="card">
        <div class="w-12 h-12 bg-emas-100 rounded-xl flex items-center justify-center mb-3">
            <svg class="w-6 h-6 text-emas-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
            </svg>
        </div>
        <h3 class="font-bold text-emas-700 mb-2">Rekap Per Lembaga</h3>
        <p class="text-sm text-gray-600 mb-4">Cetak rekap nilai semua peserta dari satu lembaga</p>
        <form action="{{ route('admin.laporan.rekap-lembaga') }}" method="POST" target="_blank">
            @csrf
            <select name="lembaga_id" required class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm mb-3 focus:outline-none focus:ring-2 focus:ring-emas-500">
                <option value="">-- Pilih Lembaga --</option>
                @foreach($lembaga as $l)
                    <option value="{{ $l->id }}">{{ $l->nama_lembaga }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn-gold text-sm w-full">Cetak PDF</button>
        </form>
    </div>

    {{-- Rekap Keseluruhan --}}
    <div class="card">
        <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mb-3">
            <svg class="w-6 h-6 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
            </svg>
        </div>
        <h3 class="font-bold text-blue-700 mb-2">Rekap Keseluruhan</h3>
        <p class="text-sm text-gray-600 mb-4">Cetak rekap nilai semua peserta dari semua lembaga</p>
        <a href="{{ route('admin.laporan.rekap-keseluruhan') }}" target="_blank" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-lg text-sm block text-center transition-colors">
            Cetak PDF
        </a>
    </div>

</div>
@endsection