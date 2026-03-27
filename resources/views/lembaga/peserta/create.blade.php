@extends('layouts.app')
@section('title', 'Tambah Murid')
@section('page-title', 'Tambah Murid')

@section('content')
<div class="max-w-2xl">
    <div class="card">
        <h3 class="text-lg font-bold text-hijau-700 mb-6">Form Tambah Murid</h3>
        <form action="{{ route('lembaga.peserta.store') }}" method="POST">
            @csrf
            <x-form-input name="nama_peserta" label="Nama Lengkap" :required="true" placeholder="Nama lengkap murid"/>
            <x-form-input label="Nama Ayah" name="nama_ayah" :value="old('nama_ayah')" />
            <x-form-input label="Nama Ibu" name="nama_ibu" :value="old('nama_ibu')" />
            <x-form-input name="nis" label="NIS" placeholder="Nomor Induk Siswa (opsional)"/>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin <span class="text-red-500">*</span></label>
                <select name="jenis_kelamin" required class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-hijau-500">
                    <option value="">-- Pilih --</option>
                    <option value="L">Laki-laki</option>
                    <option value="P">Perempuan</option>
                </select>
            </div>
            <x-form-input name="tahun_ujian" label="Tahun Ujian" type="number" :required="true" :value="date('Y')"/>
            <x-form-input name="tanggal_lahir" label="Tanggal Lahir" type="date"/>
            <div class="flex gap-3 mt-6">
                <button type="submit" class="btn-primary">Simpan Murid</button>
                <a href="{{ route('lembaga.peserta.index') }}" class="btn-outline">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection