@extends('layouts.app')
@section('title', 'Tambah Materi')
@section('page-title', 'Tambah Materi')

@section('content')
<div class="max-w-2xl">
    <div class="card">
        <h3 class="text-lg font-bold text-hijau-700 mb-6">Form Tambah Materi Ujian</h3>
        <form action="{{ route('admin.materi.store') }}" method="POST">
            @csrf
            <x-form-input name="nama_materi" label="Nama Materi" :required="true" placeholder="Contoh: Fashohah"/>
            <x-form-input name="urutan" label="Urutan Tampil" type="number" :required="true" placeholder="Contoh: 1"/>
            <x-form-input name="bobot" label="Bobot (%)" type="number" :required="true" placeholder="Contoh: 10"/>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                <textarea name="deskripsi" rows="3" placeholder="Deskripsi singkat materi ini"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm
                           focus:outline-none focus:ring-2 focus:ring-hijau-500">{{ old('deskripsi') }}</textarea>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="is_active" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-hijau-500">
                    <option value="1">Aktif</option>
                    <option value="0">Nonaktif</option>
                </select>
            </div>

            <div class="flex gap-3 mt-6">
                <button type="submit" class="btn-primary">Simpan Materi</button>
                <a href="{{ route('admin.materi.index') }}" class="btn-outline">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection