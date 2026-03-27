@extends('layouts.app')
@section('title', 'Detail Nilai')
@section('page-title', 'Detail Nilai Peserta')

@section('content')
{{-- Info Peserta --}}
<div class="card mb-4">
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div>
            <p class="text-xs text-gray-500">Nama Peserta</p>
            <p class="font-semibold">{{ $peserta->nama_peserta }}</p>
        </div>
        <div>
            <p class="text-xs text-gray-500">NIS</p>
            <p class="font-semibold">{{ $peserta->nis ?? '-' }}</p>
        </div>
        <div>
            <p class="text-xs text-gray-500">Lembaga</p>
            <p class="font-semibold">{{ $peserta->lembaga->nama_lembaga }}</p>
        </div>
        <div>
            <p class="text-xs text-gray-500">Tahun Ujian</p>
            <p class="font-semibold">{{ $peserta->tahun_ujian }}</p>
        </div>
        <div>
            <p class="text-xs text-gray-500">Nilai Akhir</p>
            <p class="font-bold text-2xl text-hijau-700">{{ $peserta->nilai_akhir ? number_format($peserta->nilai_akhir, 1) : '-' }}</p>
        </div>
        <div>
            <p class="text-xs text-gray-500">Predikat</p>
            @if($peserta->predikat)
                <span class="{{ \App\Helpers\TashihHelper::getBadgeClass($peserta->predikat) }} text-sm">
                    {{ $peserta->predikat }}
                </span>
            @else
                <span class="text-gray-400 text-sm">Belum dinilai</span>
            @endif
        </div>
        <div>
            <p class="text-xs text-gray-500">No. Sertifikat</p>
            <p class="font-mono text-xs font-semibold text-emas-700">
                {{ $peserta->sertifikat->nomor_sertifikat ?? 'Belum terbit' }}
            </p>
        </div>
        <div>
            <p class="text-xs text-gray-500">Status</p>
            @if($peserta->status_nilai === 'lengkap')
                <span class="bg-green-100 text-green-700 text-xs px-2 py-1 rounded-full">Lengkap</span>
            @else
                <span class="bg-yellow-100 text-yellow-700 text-xs px-2 py-1 rounded-full">Draft</span>
            @endif
        </div>
    </div>
</div>

{{-- Tabel Nilai per Materi --}}
@foreach($materi as $m)
<div class="card mb-4">
    <h4 class="font-bold text-hijau-700 mb-3 flex items-center gap-2">
        <span class="w-6 h-6 bg-hijau-700 text-white rounded-full text-xs flex items-center justify-center">{{ $m->urutan }}</span>
        {{ $m->nama_materi }}
        <span class="text-xs text-gray-400 font-normal">(Bobot: {{ $m->bobot }}%)</span>
    </h4>
    <table class="w-full text-sm">
        <thead>
            <tr class="bg-hijau-50">
                <th class="px-3 py-2 text-left">Item Penilaian</th>
                <th class="px-3 py-2 text-center">Nilai Maks</th>
                <th class="px-3 py-2 text-center">Nilai Diperoleh</th>
                <th class="px-3 py-2 text-center">Persentase</th>
            </tr>
        </thead>
        <tbody>
            @foreach($m->itemMateri as $item)
            @php $n = $nilaiData[$item->id] ?? null; @endphp
            <tr class="border-b border-gray-100">
                <td class="px-3 py-2">{{ $item->nama_item }}</td>
                <td class="px-3 py-2 text-center">{{ $item->nilai_max }}</td>
                <td class="px-3 py-2 text-center font-semibold {{ $n ? 'text-hijau-700' : 'text-gray-400' }}">
                    {{ $n ? $n->nilai : '-' }}
                </td>
                <td class="px-3 py-2 text-center">
                    @if($n)
                        {{ number_format(($n->nilai / $item->nilai_max) * 100, 1) }}%
                    @else
                        -
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endforeach

<div class="mt-4 flex gap-3">
    <a href="{{ route('admin.nilai.edit', $peserta) }}" class="btn-gold">✏️ Edit Nilai</a>
    <a href="{{ route('admin.nilai.index') }}" class="btn-outline">← Kembali</a>
</div>
@endsection