@extends('layouts.app')
@section('title', 'Tambah Lembaga')
@section('page-title', 'Tambah Lembaga')

@section('content')
<div class="max-w-2xl">
    <div class="card">
        <h3 class="text-lg font-bold text-hijau-700 mb-6">Form Tambah Lembaga</h3>

        <form action="{{ route('admin.lembaga.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-4">
                <x-form-input name="nama_lembaga" label="Nama Lembaga" :required="true" placeholder="Contoh: Pondok Pesantren Al-Hikmah"/>
                <x-form-input name="kode_lembaga" label="Kode Lembaga" :required="true" placeholder="Contoh: LBG02"/>
                <x-form-input name="nama_kepala" label="Nama Kepala Lembaga" placeholder="Nama lengkap kepala lembaga"/>
                <x-form-input name="telepon" label="Telepon" placeholder="08xxxxxxxxxx"/>
                <x-form-input name="email" label="Email" type="email" placeholder="email@lembaga.com"/>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                <textarea name="alamat" rows="3" placeholder="Alamat lengkap lembaga"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm
                           focus:outline-none focus:ring-2 focus:ring-hijau-500">{{ old('alamat') }}</textarea>
            </div>

            <div class="flex gap-3 mt-6">
                <button type="submit" class="btn-primary">Simpan Lembaga</button>
                <a href="{{ route('admin.lembaga.index') }}" class="btn-outline">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection