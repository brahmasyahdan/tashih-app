@extends('layouts.app')
@section('title', 'Tambah Item Materi')
@section('page-title', 'Tambah Item Materi')

@section('content')
<div class="max-w-xl">
    <div class="card">
        <h3 class="text-lg font-bold text-hijau-700 mb-1">Tambah Item Penilaian</h3>
        <p class="text-gray-500 text-sm mb-6">Materi: <span class="font-semibold text-hijau-600">{{ $materi->nama_materi }}</span></p>

        <form action="{{ route('admin.materi.item.store', $materi) }}" method="POST">
            @csrf
            <x-form-input name="nama_item" label="Nama Item" :required="true" placeholder="Contoh: Tartil"/>
            <x-form-input name="nilai_max" label="Nilai Maksimal" type="number" :required="true" placeholder="Contoh: 100"/>
            <x-form-input name="urutan" label="Urutan" type="number" :required="true" placeholder="Contoh: 1"/>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="is_active" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-hijau-500">
                    <option value="1">Aktif</option>
                    <option value="0">Nonaktif</option>
                </select>
            </div>

            <div class="flex gap-3 mt-6">
                <button type="submit" class="btn-primary">Simpan Item</button>
                <a href="{{ route('admin.materi.item.index', $materi) }}" class="btn-outline">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection