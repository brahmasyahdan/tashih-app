@extends('layouts.app')
@section('title', 'Edit Peserta')
@section('page-title', 'Edit Peserta')

@section('content')
<div class="max-w-2xl">
    <div class="card">
        <h3 class="text-lg font-bold text-hijau-700 mb-6">Form Edit Peserta</h3>
        <form action="{{ route('admin.peserta.update', $peserta) }}" method="POST">
            @csrf @method('PUT')

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Asal Lembaga <span class="text-red-500">*</span></label>
                <select name="lembaga_id" required class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-hijau-500">
                    @foreach($lembaga as $l)
                        <option value="{{ $l->id }}" {{ $peserta->lembaga_id == $l->id ? 'selected' : '' }}>{{ $l->nama_lembaga }}</option>
                    @endforeach
                </select>
            </div>

            <x-form-input label="Nama Lengkap Peserta" name="nama_peserta" :value="old('nama_peserta', $peserta->nama_peserta)" required />
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

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                <textarea name="alamat" rows="2"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-hijau-500">{{ old('alamat', $peserta->alamat) }}</textarea>
            </div>

            <div class="flex gap-3 mt-6">
                <button type="submit" class="btn-primary">Update Peserta</button>
                <a href="{{ route('admin.peserta.index') }}" class="btn-outline">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection