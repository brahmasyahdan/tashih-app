@extends('layouts.app')
@section('title', 'Item Materi')
@section('page-title', 'Item Materi')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.materi.index') }}" class="text-hijau-600 hover:text-hijau-800 text-sm flex items-center gap-1">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Kembali ke Materi
    </a>
</div>

<div class="card">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h3 class="text-lg font-bold text-hijau-700">Item Penilaian: {{ $materi->nama_materi }}</h3>
            <p class="text-gray-500 text-sm">Bobot: {{ $materi->bobot }}%</p>
        </div>
        <a href="{{ route('admin.materi.item.create', $materi) }}" class="btn-primary flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Item
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-hijau-700 text-white">
                    <th class="px-4 py-3 text-left rounded-tl-lg">Urutan</th>
                    <th class="px-4 py-3 text-left">Nama Item</th>
                    <th class="px-4 py-3 text-center">Nilai Maks</th>
                    <th class="px-4 py-3 text-center">Status</th>
                    <th class="px-4 py-3 text-center rounded-tr-lg">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $item)
                <tr class="border-b border-gray-100 hover:bg-hijau-50 transition-colors">
                    <td class="px-4 py-3 text-center">
                        <span class="w-7 h-7 bg-hijau-100 text-hijau-700 rounded-full flex items-center justify-center font-bold text-xs mx-auto">
                            {{ $item->urutan }}
                        </span>
                    </td>
                    <td class="px-4 py-3 font-medium">{{ $item->nama_item }}</td>
                    <td class="px-4 py-3 text-center">
                        <span class="bg-emas-100 text-emas-700 text-xs px-2 py-1 rounded-full font-semibold">
                            {{ $item->nilai_max }}
                        </span>
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
                            <a href="{{ route('admin.materi.item.edit', [$materi, $item]) }}"
                               class="text-xs bg-emas-100 text-emas-700 hover:bg-emas-200 px-3 py-1 rounded-lg font-medium">
                                Edit
                            </a>
                            <form action="{{ route('admin.materi.item.destroy', [$materi, $item]) }}" method="POST"
                                  onsubmit="return confirm('Yakin ingin menghapus item ini?')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                        class="text-xs bg-red-100 text-red-700 hover:bg-red-200 px-3 py-1 rounded-lg font-medium">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-4 py-8 text-center text-gray-400">Belum ada item penilaian</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $items->links() }}</div>
</div>
@endsection