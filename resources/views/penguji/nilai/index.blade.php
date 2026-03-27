@extends('layouts.app')
@section('title', 'Input Nilai')
@section('page-title', 'Input Nilai')

@section('content')
<div class="card">
    <h3 class="text-lg font-bold text-hijau-700 mb-6">Daftar Peserta — Input Nilai</h3>
    {{-- Filter --}}
    <form method="GET" class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-4 p-4 bg-hijau-50 rounded-lg">
        <input type="text" name="search" value="{{ request('search') }}"
            placeholder="Cari nama peserta / NIS..."
            class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-hijau-500 col-span-2 md:col-span-1">

        <select name="lembaga_id" class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-hijau-500">
            <option value="">Semua Lembaga</option>
            @foreach($lembaga as $l)
                <option value="{{ $l->id }}" {{ request('lembaga_id') == $l->id ? 'selected' : '' }}>
                    {{ $l->nama_lembaga }}
                </option>
            @endforeach
        </select>

        <select name="tahun_ujian" class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-hijau-500">
            <option value="">Semua Tahun</option>
            @foreach($tahunList as $tahun)
                <option value="{{ $tahun }}" {{ request('tahun_ujian') == $tahun ? 'selected' : '' }}>{{ $tahun }}</option>
            @endforeach
        </select>

        <div class="flex gap-2 col-span-2 md:col-span-4">
            <button type="submit" class="btn-primary text-sm px-4 py-2 flex items-center justify-center gap-2">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <span>Filter</span>
            </button>
            <a href="{{ route('penguji.nilai.index') }}" class="btn-outline text-sm px-4 py-2">Reset</a>
        </div>
    </form>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-hijau-700 text-white">
                    <th class="px-3 py-3 text-left rounded-tl-lg">No</th>
                    <th class="px-3 py-3 text-left">Nama Peserta</th>
                    <th class="px-3 py-3 text-left">Lembaga</th>
                    <th class="px-3 py-3 text-center">Tahun</th>
                    <th class="px-3 py-3 text-center">Status</th>
                    <th class="px-3 py-3 text-center rounded-tr-lg">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($peserta as $item)
                <tr class="border-b border-gray-100 hover:bg-hijau-50 transition-colors">
                    <td class="px-3 py-3 text-gray-500">{{ $loop->iteration }}</td>
                    <td class="px-3 py-3 font-medium">{{ $item->nama_peserta }}</td>
                    <td class="px-3 py-3 text-gray-600">{{ $item->lembaga->nama_lembaga ?? '-' }}</td>
                    <td class="px-3 py-3 text-center">{{ $item->tahun_ujian }}</td>
                    <td class="px-3 py-3 text-center">
                        @if($item->status_nilai === 'lengkap')
                            <span class="bg-green-100 text-green-700 text-xs px-2 py-1 rounded-full">Lengkap</span>
                        @else
                            <span class="bg-yellow-100 text-yellow-700 text-xs px-2 py-1 rounded-full">Draft</span>
                        @endif
                    </td>
                    <td class="px-3 py-3 text-center">
                        <a href="{{ route('penguji.nilai.show', $item) }}"
                           class="text-xs bg-hijau-100 text-hijau-700 hover:bg-hijau-200 px-3 py-1 rounded-lg font-medium">
                            Input Nilai
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-4 py-8 text-center text-gray-400">Belum ada peserta</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $peserta->links() }}</div>
</div>
@endsection