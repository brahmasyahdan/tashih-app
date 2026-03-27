@extends('layouts.app')
@section('title', 'Rekap Nilai')
@section('page-title', 'Rekap Nilai')

@section('content')
<div class="card">
    <h3 class="text-lg font-bold text-hijau-700 mb-6">Rekap Nilai Semua Peserta</h3>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-hijau-700 text-white">
                    <th class="px-3 py-3 text-left rounded-tl-lg">No</th>
                    <th class="px-3 py-3 text-left">Nama Peserta</th>
                    <th class="px-3 py-3 text-left">Lembaga</th>
                    <th class="px-3 py-3 text-center">Tahun</th>
                    <th class="px-3 py-3 text-center">Nilai Akhir</th>
                    <th class="px-3 py-3 text-center">Predikat</th>
                    <th class="px-3 py-3 text-center">No. Sertifikat</th>
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
                    <td class="px-3 py-3 text-center font-bold text-hijau-700">
                        {{ $item->nilai_akhir ? number_format($item->nilai_akhir, 1) : '-' }}
                    </td>
                    <td class="px-3 py-3 text-center">
                        @if($item->predikat)
                            <span class="{{ \App\Helpers\TashihHelper::getBadgeClass($item->predikat) }}">
                                {{ $item->predikat }}
                            </span>
                        @else
                            <span class="text-gray-400 text-xs">-</span>
                        @endif
                    </td>
                    <td class="px-3 py-3 text-center font-mono text-xs">
                        {{ $item->sertifikat->nomor_sertifikat ?? '-' }}
                    </td>
                    <td class="px-3 py-3 text-center">
                        <a href="{{ route('admin.nilai.show', $item) }}"
                           class="text-xs bg-hijau-100 text-hijau-700 hover:bg-hijau-200 px-3 py-1 rounded-lg font-medium">
                            Detail
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-4 py-8 text-center text-gray-400">Belum ada data nilai</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $peserta->links() }}</div>
</div>
@endsection