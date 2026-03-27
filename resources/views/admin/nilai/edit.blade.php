@extends('layouts.app')
@section('title', 'Edit Nilai')
@section('page-title', 'Edit Nilai Peserta')

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
    </div>
</div>

{{-- Form Edit Nilai --}}
<form action="{{ route('admin.nilai.update', $peserta) }}" method="POST">
    @csrf @method('PUT')

    @foreach($materi as $m)
    <div class="card mb-4">
        <h4 class="font-bold text-hijau-700 mb-3 flex items-center gap-2">
            <span class="w-6 h-6 bg-hijau-700 text-white rounded-full text-xs flex items-center justify-center">
                {{ $m->urutan }}
            </span>
            {{ $m->nama_materi }}
            <span class="text-xs text-gray-400 font-normal">(Bobot: {{ $m->bobot }}%)</span>
        </h4>

        <table class="w-full text-sm">
            <thead>
                <tr class="bg-hijau-50">
                    <th class="px-3 py-2 text-left">Item Penilaian</th>
                    <th class="px-3 py-2 text-center w-24">Nilai Maks</th>
                    <th class="px-3 py-2 text-center w-32">Nilai</th>
                    <th class="px-3 py-2 text-left">Catatan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($m->itemMateri as $item)
                @php $n = $nilaiData[$item->id] ?? null; @endphp
                <tr class="border-b border-gray-100">
                    <td class="px-3 py-2">{{ $item->nama_item }}</td>
                    <td class="px-3 py-2 text-center text-gray-500">{{ $item->nilai_max }}</td>
                    <td class="px-3 py-2">
                        <input type="hidden" name="materi_id[{{ $item->id }}]" value="{{ $m->id }}">
                        <input type="hidden" name="item_materi_id[{{ $item->id }}]" value="{{ $item->id }}">
                        <input type="hidden" name="penguji_id[{{ $item->id }}]" value="{{ $n ? $n->penguji_id : auth()->id() }}">

                        <input type="number"
                               name="nilai[{{ $item->id }}]"
                               value="{{ $n ? $n->nilai : '' }}"
                               min="0" max="{{ $item->nilai_max }}"
                               step="0.5"
                               placeholder="0"
                               class="w-full px-2 py-1 border border-gray-300 rounded text-center text-sm
                                      focus:outline-none focus:ring-2 focus:ring-hijau-500">
                    </td>
                    <td class="px-3 py-2">
                        <input type="text"
                               name="catatan[{{ $item->id }}]"
                               value="{{ $n ? $n->catatan : '' }}"
                               placeholder="Catatan (opsional)"
                               class="w-full px-2 py-1 border border-gray-300 rounded text-sm
                                      focus:outline-none focus:ring-2 focus:ring-hijau-500">
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endforeach

    <div class="flex gap-3 mt-4">
        <button type="submit" class="btn-primary">💾 Simpan Perubahan Nilai</button>
        <a href="{{ route('admin.nilai.show', $peserta) }}" class="btn-outline">Batal</a>
    </div>
</form>
@endsection