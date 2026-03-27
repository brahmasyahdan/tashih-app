@extends('layouts.app')
@section('title', 'Data Lembaga')
@section('page-title', 'Data Lembaga')

@section('content')
<div class="card">
    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h3 class="text-lg font-bold text-hijau-700">Daftar Lembaga</h3>
            <p class="text-gray-500 text-sm">Kelola data lembaga peserta ujian</p>
        </div>
        <a href="{{ route('admin.lembaga.create') }}" class="btn-primary flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Lembaga
        </a>
    </div>

    {{-- Tabel --}}
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-hijau-700 text-white">
                    <th class="px-4 py-3 text-left rounded-tl-lg">No</th>
                    <th class="px-4 py-3 text-left">Kode</th>
                    <th class="px-4 py-3 text-left">Nama Lembaga</th>
                    <th class="px-4 py-3 text-left">Kepala</th>
                    <th class="px-4 py-3 text-left">Kontak</th>
                    <th class="px-4 py-3 text-left">Status</th>
                    <th class="px-4 py-3 text-center rounded-tr-lg">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($lembaga as $item)
                <tr class="border-b border-gray-100 hover:bg-hijau-50 transition-colors">
                    <td class="px-4 py-3 text-gray-500">{{ $loop->iteration + ($lembaga->currentPage()-1) * $lembaga->perPage() }}</td>
                    <td class="px-4 py-3 font-mono text-xs bg-emas-50 text-emas-700 font-semibold">{{ $item->kode_lembaga }}</td>
                    <td class="px-4 py-3 font-medium">{{ $item->nama_lembaga }}</td>
                    <td class="px-4 py-3 text-gray-600">{{ $item->nama_kepala ?? '-' }}</td>
                    <td class="px-4 py-3 text-gray-600">{{ $item->telepon ?? $item->email ?? '-' }}</td>
                    <td class="px-4 py-3">
                        @if($item->is_active)
                            <span class="bg-green-100 text-green-700 text-xs px-2 py-1 rounded-full font-medium">Aktif</span>
                        @else
                            <span class="bg-red-100 text-red-700 text-xs px-2 py-1 rounded-full font-medium">Nonaktif</span>
                        @endif
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('admin.lembaga.edit', $item) }}" 
                               class="text-xs bg-emas-100 text-emas-700 hover:bg-emas-200 px-3 py-1 rounded-lg font-medium transition-colors">
                                Edit
                            </a>
                            <form action="{{ route('admin.lembaga.destroy', $item) }}" method="POST"
                                  onsubmit="return confirm('Yakin ingin menghapus lembaga ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" 
                                        class="text-xs bg-red-100 text-red-700 hover:bg-red-200 px-3 py-1 rounded-lg font-medium transition-colors">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-4 py-8 text-center text-gray-400">
                        Belum ada data lembaga
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-4">
        {{ $lembaga->links() }}
    </div>
</div>
@endsection