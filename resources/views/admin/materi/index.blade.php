@extends('layouts.app')
@section('title', 'Materi Ujian')
@section('page-title', 'Materi Ujian')

@section('content')
<div class="card">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h3 class="text-lg font-bold text-hijau-700">Daftar Materi Ujian</h3>
            <p class="text-gray-500 text-sm">Kelola materi dan item penilaian ujian Tashih</p>
        </div>
        <a href="{{ route('admin.materi.create') }}" class="btn-primary flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Materi
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-hijau-700 text-white">
                    <th class="px-4 py-3 text-left rounded-tl-lg">Urutan</th>
                    <th class="px-4 py-3 text-left">Nama Materi</th>
                    <th class="px-4 py-3 text-left">Deskripsi</th>
                    <th class="px-4 py-3 text-center">Bobot</th>
                    <th class="px-4 py-3 text-center">Item</th>
                    <th class="px-4 py-3 text-center">Status</th>
                    <th class="px-4 py-3 text-center rounded-tr-lg">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($materi as $item)
                <tr class="border-b border-gray-100 hover:bg-hijau-50 transition-colors">
                    <td class="px-4 py-3 text-center">
                        <span class="w-7 h-7 bg-hijau-100 text-hijau-700 rounded-full flex items-center justify-center font-bold text-xs mx-auto">
                            {{ $item->urutan }}
                        </span>
                    </td>
                    <td class="px-4 py-3 font-medium">{{ $item->nama_materi }}</td>
                    <td class="px-4 py-3 text-gray-500 text-xs">{{ Str::limit($item->deskripsi, 50) ?? '-' }}</td>
                    <td class="px-4 py-3 text-center">
                        <span class="bg-emas-100 text-emas-700 text-xs px-2 py-1 rounded-full font-semibold">
                            {{ $item->bobot }}%
                        </span>
                    </td>
                    <td class="px-4 py-3 text-center">
                        <a href="{{ route('admin.materi.item.index', $item) }}"
                           class="text-hijau-600 hover:text-hijau-800 font-semibold underline">
                            {{ $item->itemMateri()->count() }} item
                        </a>
                    </td>
                    <td class="px-4 py-3 text-center">
                        @if($item->is_active)
                            <span class="bg-green-100 text-green-700 text-xs px-2 py-1 rounded-full">Aktif</span>
                        @else
                            <span class="bg-red-100 text-red-700 text-xs px-2 py-1 rounded-full">Nonaktif</span>
                        @endif
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('admin.materi.item.index', $item) }}"
                               class="text-xs bg-hijau-100 text-hijau-700 hover:bg-hijau-200 px-3 py-1 rounded-lg font-medium transition-colors">
                                Item
                            </a>
                            <a href="{{ route('admin.materi.edit', $item) }}"
                               class="text-xs bg-emas-100 text-emas-700 hover:bg-emas-200 px-3 py-1 rounded-lg font-medium transition-colors">
                                Edit
                            </a>
                            <form action="{{ route('admin.materi.destroy', $item) }}" method="POST"
                                  onsubmit="return confirm('Yakin ingin menghapus materi ini?')">
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
                    <td colspan="7" class="px-4 py-8 text-center text-gray-400">Belum ada materi ujian</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $materi->links() }}</div>
</div>
@endsection