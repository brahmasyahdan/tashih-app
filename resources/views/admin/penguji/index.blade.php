@extends('layouts.app')
@section('title', 'Data Penguji')
@section('page-title', 'Data Penguji')

@section('content')
<div class="card">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h3 class="text-lg font-bold text-hijau-700">Daftar Penguji</h3>
            <p class="text-gray-500 text-sm">Kelola akun penguji ujian Tashih</p>
        </div>
        <a href="{{ route('admin.penguji.create') }}" class="btn-primary flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Penguji
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-hijau-700 text-white">
                    <th class="px-4 py-3 text-left rounded-tl-lg">No</th>
                    <th class="px-4 py-3 text-left">Nama</th>
                    <th class="px-4 py-3 text-left">Email</th>
                    <th class="px-4 py-3 text-left">Telepon</th>
                    <th class="px-4 py-3 text-left">Materi Ditugaskan</th>
                    <th class="px-4 py-3 text-center rounded-tr-lg">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($penguji as $item)
                <tr class="border-b border-gray-100 hover:bg-hijau-50 transition-colors">
                    <td class="px-4 py-3 text-gray-500">{{ $loop->iteration }}</td>
                    <td class="px-4 py-3 font-medium">{{ $item->name }}</td>
                    <td class="px-4 py-3 text-gray-600">{{ $item->email }}</td>
                    <td class="px-4 py-3 text-gray-600">{{ $item->telepon ?? '-' }}</td>
                    <td class="px-4 py-3">
                        @php $materiList = $item->materiYangDiuji; @endphp
                        @if($materiList->isNotEmpty())
                            <div class="flex flex-wrap gap-1">
                                @foreach($materiList as $m)
                                <span class="bg-hijau-100 text-hijau-700 text-xs px-2 py-1 rounded-full">
                                    {{ $m->nama_materi }}
                                </span>
                                @endforeach
                            </div>
                        @else
                            <span class="text-gray-400 text-xs">Belum ada penugasan</span>
                        @endif
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('admin.penguji.edit', $item) }}"
                            class="text-xs bg-emas-100 text-emas-700 hover:bg-emas-200 px-3 py-1 rounded-lg font-medium transition-colors">
                                Edit
                            </a>
                            <form action="{{ route('admin.penguji.destroy', $item) }}" method="POST"
                                onsubmit="return confirm('Yakin ingin menghapus penguji ini?')">
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
                    <td colspan="6" class="px-4 py-8 text-center text-gray-400">Belum ada data penguji</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $penguji->links() }}</div>
</div>
@endsection