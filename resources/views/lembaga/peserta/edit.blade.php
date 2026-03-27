@extends('layouts.app')
@section('title', 'Edit Murid')
@section('page-title', 'Edit Murid')

@section('content')
<div class="max-w-2xl">
    <div class="card">
        <h3 class="text-lg font-bold text-hijau-700 mb-6">Form Edit Murid</h3>
        <form action="{{ route('lembaga.peserta.update', $peserta) }}" method="POST">
            @csrf @method('PUT')
            <x-form-input name="nama_peserta" label="Nama Lengkap" :required="true" :value="$peserta->nama_peserta"/>
            <x-form-input label="Nama Ayah" name="nama_ayah" :value="old('nama_ayah', $peserta->nama_ayah)" />
            <x-form-input label="Nama Ibu" name="nama_ibu" :value="old('nama_ibu', $peserta->nama_ibu)" />
            <x-form-input name="nis" label="NIS" :value="$peserta->nis"/>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin <span class="text-red-500">*</span></label>
                <select name="jenis_kelamin" required class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-hijau-500">
                    <option value="L" {{ $peserta->jenis_kelamin == 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ $peserta->jenis_kelamin == 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>
            <x-form-input name="tahun_ujian" label="Tahun Ujian" type="number" :required="true" :value="$peserta->tahun_ujian"/>
            <x-form-input name="tanggal_lahir" label="Tanggal Lahir" type="date" :value="$peserta->tanggal_lahir"/>
            <div class="flex gap-3 mt-6">
                <button type="submit" class="btn-primary">Update Murid</button>
                <a href="{{ route('lembaga.peserta.index') }}" class="btn-outline">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection