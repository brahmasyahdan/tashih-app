@extends('layouts.app')
@section('title', 'Edit Lembaga')
@section('page-title', 'Edit Lembaga')

@section('content')
<div class="max-w-2xl">
    <div class="card">
        <h3 class="text-lg font-bold text-hijau-700 mb-6">Form Edit Lembaga</h3>

        <form action="{{ route('admin.lembaga.update', $lembaga) }}" method="POST">
            @csrf @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-4">
                <x-form-input name="nama_lembaga" label="Nama Lembaga" :required="true" :value="$lembaga->nama_lembaga"/>
                <x-form-input name="kode_lembaga" label="Kode Lembaga" :required="true" :value="$lembaga->kode_lembaga"/>
                <x-form-input name="nama_kepala" label="Nama Kepala Lembaga" :value="$lembaga->nama_kepala"/>
                <x-form-input name="telepon" label="Telepon" :value="$lembaga->telepon"/>
                <x-form-input name="email" label="Email" type="email" :value="$lembaga->email"/>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                <textarea name="alamat" rows="3"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm
                           focus:outline-none focus:ring-2 focus:ring-hijau-500">{{ old('alamat', $lembaga->alamat) }}</textarea>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="is_active" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-hijau-500">
                    <option value="1" {{ $lembaga->is_active ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ !$lembaga->is_active ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>

            <div class="flex gap-3 mt-6">
                <button type="submit" class="btn-primary">Update Lembaga</button>
                <a href="{{ route('admin.lembaga.index') }}" class="btn-outline">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection