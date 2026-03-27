@extends('layouts.app')
@section('title', 'Form Input Nilai')
@section('page-title', 'Form Input Nilai')

@section('content')
{{-- Info Peserta --}}
<div class="card mb-4 bg-hijau-50 border-hijau-200">
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
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

@php
    // Cek apakah penguji sudah finalisasi nilai untuk peserta ini
    $sudahFinal = \App\Models\Nilai::where('peserta_id', $peserta->id)
                                    ->where('penguji_id', Auth::id())
                                    ->where('is_final', true)
                                    ->exists();
@endphp

@php
    // Cek apakah ada nilai yang diedit admin
    $adaEditAdmin = \App\Models\Nilai::where('peserta_id', $peserta->id)
                                      ->where('penguji_id', Auth::id())
                                      ->where('edited_by_admin', true)
                                      ->exists();
@endphp

@if($adaEditAdmin && $sudahFinal)
    <div class="card mb-4 bg-blue-50 border-blue-300">
        <div class="flex items-center gap-3">
            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div>
                <p class="font-semibold text-blue-800">Nilai Telah Direvisi oleh Admin</p>
                <p class="text-sm text-blue-700">Beberapa nilai telah diperbarui oleh administrator. Silakan periksa nilai terbaru di bawah.</p>
            </div>
        </div>
    </div>
@endif



@if($sudahFinal)
    {{-- Tampilan Read-Only jika sudah final --}}
    <div class="card mb-4 bg-yellow-50 border-yellow-300">
        <div class="flex items-center gap-3">
            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
            <div>
                <p class="font-semibold text-yellow-800">Penilaian Sudah Difinalisasi</p>
                <p class="text-sm text-yellow-700">Anda sudah menyelesaikan penilaian untuk peserta ini. Nilai tidak bisa diubah lagi.</p>
            </div>
        </div>
    </div>

    {{-- Tampilkan nilai yang sudah diinput (read-only) --}}
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
                    <td class="px-3 py-2 text-center">
                        <span class="font-semibold text-hijau-700">{{ $n ? $n->nilai : '-' }}</span>
                    </td>
                    <td class="px-3 py-2 text-gray-600 text-sm">{{ $n ? $n->catatan : '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endforeach

    <div class="mt-4">
        <a href="{{ route('penguji.nilai.index') }}" class="btn-outline">← Kembali ke Daftar Peserta</a>
    </div>

@else
    {{-- Form Input Nilai (jika belum final) --}}
    <form action="{{ route('penguji.nilai.store', $peserta) }}" method="POST">
        @csrf

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

        <div class="card bg-yellow-50 border-yellow-200 mb-4">
            <div class="flex items-start gap-3">
                <svg class="w-5 h-5 text-yellow-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div>
                    <p class="font-semibold text-yellow-800 text-sm mb-1">Perhatian!</p>
                    <p class="text-xs text-yellow-700">Setelah menekan tombol "Simpan & Finalisasi", nilai akan terkunci dan tidak bisa diubah lagi. Pastikan semua nilai sudah benar sebelum menyimpan.</p>
                </div>
            </div>
        </div>

        <div class="flex gap-3 mt-4">
            <button type="button" onclick="confirmSubmit()" class="btn-primary flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                💾 Simpan & Finalisasi Nilai
            </button>
            <a href="{{ route('penguji.nilai.index') }}" class="btn-outline">Batal</a>
        </div>
    </form>
@endif
<script>
function confirmSubmit() {
    const inputs = document.querySelectorAll('input[type="number"][name^="nilai"]');
    let terisi = 0;
    let total = inputs.length;
    
    inputs.forEach(input => {
        if (input.value && parseFloat(input.value) > 0) {
            terisi++;
        }
    });
    
    let message = `Anda akan menyelesaikan penilaian untuk peserta ini.\n\n`;
    message += `📊 Item terisi: ${terisi} dari ${total} item\n`;
    message += `⚠️ Setelah disimpan, nilai tidak bisa diubah lagi!\n\n`;
    message += `Apakah nilai sudah benar semua?`;
    
    if (confirm(message)) {
        document.querySelector('form').submit();
    }
}

// Prevent enter key from submitting form
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('keypress', function(e) {
            if (e.key === 'Enter' && e.target.tagName !== 'TEXTAREA') {
                e.preventDefault();
                return false;
            }
        });
    }
});
</script>
@endsection