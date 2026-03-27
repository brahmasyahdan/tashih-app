@extends('layouts.app')
@section('title', 'Tambah Penguji')
@section('page-title', 'Tambah Penguji')

@section('content')
<div class="max-w-2xl">
    <div class="card">
        <h3 class="text-lg font-bold text-hijau-700 mb-6">Form Tambah Penguji</h3>
        <form action="{{ route('admin.penguji.store') }}" method="POST">
            @csrf
            <x-form-input name="name" label="Nama Lengkap" :required="true" placeholder="Nama lengkap penguji"/>
            <x-form-input name="email" label="Email" type="email" :required="true" placeholder="email@penguji.com"/>
            <x-form-input name="telepon" label="Telepon" placeholder="08xxxxxxxxxx"/>
            <x-form-input name="password" label="Password" type="password" :required="true" placeholder="Minimal 8 karakter"/>
            <x-form-input name="password_confirmation" label="Konfirmasi Password" type="password" :required="true" placeholder="Ulangi password"/>

            {{-- Penugasan Materi --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Materi yang Ditugaskan <span class="text-red-500">*</span>
                </label>
                <div class="border border-gray-300 rounded-lg p-4 bg-gray-50 max-h-64 overflow-y-auto">
                    @foreach($materi as $m)
                    <label class="flex items-center gap-2 mb-2 hover:bg-white p-2 rounded cursor-pointer">
                        <input type="checkbox" name="materi_ids[]" value="{{ $m->id }}"
                               class="w-4 h-4 text-hijau-600 border-gray-300 rounded focus:ring-hijau-500">
                        <span class="w-6 h-6 bg-hijau-700 text-white rounded-full text-xs flex items-center justify-center flex-shrink-0">
                            {{ $m->urutan }}
                        </span>
                        <span class="text-sm">{{ $m->nama_materi }}</span>
                    </label>
                    @endforeach
                </div>
                <p class="text-xs text-gray-500 mt-1">Penguji hanya bisa menilai materi yang dipilih di atas</p>
                @error('materi_ids') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex gap-3 mt-6">
                <button type="submit" class="btn-primary">Simpan Penguji</button>
                <a href="{{ route('admin.penguji.index') }}" class="btn-outline">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection