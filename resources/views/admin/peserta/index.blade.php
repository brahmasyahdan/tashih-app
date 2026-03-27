@extends('layouts.app')
@section('title', 'Data Peserta')
@section('page-title', 'Data Peserta')

@section('content')
<div class="card">
    <div class="flex items-center justify-between mb-4">
        <div>
            <h3 class="text-lg font-bold text-hijau-700">Daftar Peserta Ujian</h3>
            <p class="text-gray-500 text-sm">Total: {{ $peserta->total() }} peserta</p>
        </div>
        <a href="{{ route('admin.peserta.create') }}" class="btn-primary flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Peserta
        </a>
    </div>

    {{-- Filter --}}
    <form method="GET" class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-4 p-4 bg-hijau-50 rounded-lg">
        <input type="text" name="search" value="{{ request('search') }}"
               placeholder="Cari nama / NIS..."
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

        <select name="predikat" class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-hijau-500">
            <option value="">Semua Predikat</option>
            @foreach(['Mumtaz','Jayyid Jiddan','Jayyid','Maqbul','Dhaif'] as $p)
                <option value="{{ $p }}" {{ request('predikat') == $p ? 'selected' : '' }}>{{ $p }}</option>
            @endforeach
        </select>

        <div class="flex gap-2 col-span-2 md:col-span-4">
            <button type="submit" class="btn-primary text-sm px-4 py-2 flex items-center justify-center gap-2">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <span>Filter</span>
            </button>
            <a href="{{ route('admin.peserta.index') }}" class="btn-outline text-sm px-4 py-2">Reset</a>
        </div>
    </form>

    {{-- Tabel --}}
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-hijau-700 text-white">
                    <th class="px-3 py-3 text-left rounded-tl-lg">No</th>
                    <th class="px-3 py-3 text-left">Nama Peserta</th>
                    <th class="px-3 py-3 text-left">Nama Ayah</th>
                    <th class="px-3 py-3 text-left">Nama Ibu</th>
                    <th class="px-3 py-3 text-left">NIS</th>
                    <th class="px-3 py-3 text-left">Lembaga</th>
                    <th class="px-3 py-3 text-center">Tahun</th>
                    <th class="px-3 py-3 text-center">Nilai Akhir</th>
                    <th class="px-3 py-3 text-center">Predikat</th>
                    <th class="px-3 py-3 text-center">Status</th>
                    <th class="px-3 py-3 text-center rounded-tr-lg">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($peserta as $item)
                <tr class="border-b border-gray-100 hover:bg-hijau-50 transition-colors">
                    <td class="px-3 py-3 text-gray-500">{{ $loop->iteration + ($peserta->currentPage()-1) * $peserta->perPage() }}</td>
                    <td class="px-3 py-3 font-medium">{{ $item->nama_peserta }}</td>
                    <td class="px-3 py-3 text-gray-600 text-sm">{{ $item->nama_ayah ?? '-' }}</td>
                    <td class="px-3 py-3 text-gray-600 text-sm">{{ $item->nama_ibu ?? '-' }}</td>
                    <td class="px-3 py-3 text-gray-500 font-mono text-xs">{{ $item->nis ?? '-' }}</td>
                    <td class="px-3 py-3 text-gray-600">{{ $item->lembaga->nama_lembaga ?? '-' }}</td>
                    <td class="px-3 py-3 text-center">{{ $item->tahun_ujian }}</td>
                    <td class="px-3 py-3 text-center font-bold text-hijau-700">
                        {{ $item->nilai_akhir ? number_format($item->nilai_akhir, 1) : '-' }}
                    </td>
                    <td class="px-3 py-3 text-center">
                        @if($item->predikat && $item->nilai_akhir > 0)
                            <span class="{{ \App\Helpers\TashihHelper::getBadgeClass($item->predikat) }}">
                                {{ $item->predikat }}
                            </span>
                        @else
                            <span class="text-gray-400 text-xs">-</span>
                        @endif
                    </td>
                    <td class="px-3 py-3 text-center">
                        @php 
                            $statusInfo = \App\Helpers\TashihHelper::hitungStatusNilai($item->id); 
                        @endphp
                        <div class="relative group inline-block">
                            <span class="{{ $statusInfo['badge_class'] }} text-xs px-2 py-1 rounded-full cursor-help">
                                {{ $statusInfo['label'] }}
                            </span>
                            
                            {{-- Tooltip --}}
                            <div class="hidden group-hover:block absolute z-10 w-64 p-3 bg-gray-900 text-white text-xs rounded-lg shadow-lg bottom-full left-1/2 transform -translate-x-1/2 mb-2">
                                <p class="font-semibold mb-2">Detail Penilaian ({{ $statusInfo['terisi'] }}/{{ $statusInfo['total'] }} item)</p>
                                @php $detail = \App\Helpers\TashihHelper::getDetailPenilaian($item->id); @endphp
                                @foreach($detail as $d)
                                <div class="flex items-center justify-between mb-1">
                                    <span class="text-xs">{{ $d['materi'] }}</span>
                                    <span class="text-xs {{ $d['lengkap'] ? 'text-green-400' : 'text-yellow-400' }}">
                                        {{ $d['terisi'] }}/{{ $d['total'] }}
                                        @if($d['lengkap']) ✓ @endif
                                    </span>
                                </div>
                                @endforeach
                                <div class="w-full bg-gray-700 rounded-full h-2 mt-2">
                                    <div class="bg-green-500 h-2 rounded-full" style="width: {{ $statusInfo['progress'] }}%"></div>
                                </div>
                                <p class="text-center mt-1 text-xs">{{ $statusInfo['progress'] }}% selesai</p>
                                
                                {{-- Arrow tooltip --}}
                                <div class="absolute left-1/2 transform -translate-x-1/2 -bottom-1 w-0 h-0 border-l-4 border-r-4 border-t-4 border-l-transparent border-r-transparent border-t-gray-900"></div>
                            </div>
                        </div>
                    </td>
                    <td class="px-3 py-3">
                        <div class="flex items-center justify-center gap-1">
                            <a href="{{ route('admin.nilai.show', $item) }}"
                               class="text-xs bg-hijau-100 text-hijau-700 hover:bg-hijau-200 px-2 py-1 rounded-lg font-medium">
                                Nilai
                            </a>
                            <a href="{{ route('admin.laporan.kartu-nilai', $item) }}" target="_blank"
                                class="text-xs bg-blue-100 text-blue-700 hover:bg-blue-200 px-2 py-1 rounded-lg font-medium">
                                Cetak
                            </a>
                            <a href="{{ route('admin.peserta.edit', $item) }}"
                               class="text-xs bg-emas-100 text-emas-700 hover:bg-emas-200 px-2 py-1 rounded-lg font-medium">
                                Edit
                            </a>
                            <form action="{{ route('admin.peserta.destroy', $item) }}" method="POST"
                                  onsubmit="return confirm('Yakin hapus peserta ini?')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                        class="text-xs bg-red-100 text-red-700 hover:bg-red-200 px-2 py-1 rounded-lg font-medium">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="11" class="px-4 py-8 text-center text-gray-400">Belum ada data peserta</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $peserta->links() }}</div>
</div>
@endsection