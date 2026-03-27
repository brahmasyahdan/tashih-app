@extends('layouts.app')
@section('title', 'Tambah Peserta')
@section('page-title', 'Tambah Peserta')

@section('content')
<div class="max-w-2xl">
    <div class="card">
        <h3 class="text-lg font-bold text-hijau-700 mb-6">Form Tambah Peserta</h3>
        <form action="{{ route('admin.peserta.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Asal Lembaga <span class="text-red-500">*</span></label>
                <select name="lembaga_id" required class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-hijau-500 @error('lembaga_id') border-red-400 @enderror">
                    <option value="">-- Pilih Lembaga --</option>
                    @foreach($lembaga as $l)
                        <option value="{{ $l->id }}" {{ old('lembaga_id') == $l->id ? 'selected' : '' }}>{{ $l->nama_lembaga }}</option>
                    @endforeach
                </select>
                @error('lembaga_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <x-form-input label="Nama Lengkap Peserta" name="nama_peserta" value="old('nama_peserta')" required />
            <x-form-input label="Nama Ayah" name="nama_ayah" :value="old('nama_ayah')" />
            <x-form-input label="Nama Ibu" name="nama_ibu" :value="old('nama_ibu')" />
            <x-form-input name="nis" label="NIS" placeholder="Nomor Induk Siswa (opsional)"/>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin <span class="text-red-500">*</span></label>
                <select name="jenis_kelamin" required class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-hijau-500">
                    <option value="">-- Pilih --</option>
                    <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>

            <x-form-input name="tahun_ujian" label="Tahun Ujian" type="number" :required="true" placeholder="{{ date('Y') }}" :value="date('Y')"/>
            <x-form-input name="tanggal_lahir" label="Tanggal Lahir" type="date"/>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                <textarea name="alamat" rows="2" placeholder="Alamat peserta (opsional)"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-hijau-500">{{ old('alamat') }}</textarea>
            </div>

            <div class="flex gap-3 mt-6">
                <button type="submit" class="btn-primary">Simpan Peserta</button>
                <a href="{{ route('admin.peserta.index') }}" class="btn-outline">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection