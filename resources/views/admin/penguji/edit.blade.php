@extends('layouts.app')
@section('title', 'Edit Penguji')
@section('page-title', 'Edit Penguji')

@section('content')
<div class="max-w-2xl">
    <div class="card">
        <h3 class="text-lg font-bold text-hijau-700 mb-6">Form Edit Penguji</h3>
        <form action="{{ route('admin.penguji.update', $penguji) }}" method="POST">
            @csrf @method('PUT')
            <x-form-input name="name" label="Nama Lengkap" :required="true" :value="$penguji->name"/>
            <x-form-input name="email" label="Email" type="email" :required="true" :value="$penguji->email"/>
            <x-form-input name="telepon" label="Telepon" :value="$penguji->telepon"/>

            {{-- Penugasan Materi --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Materi yang Ditugaskan <span class="text-red-500">*</span>
                </label>
                <div class="border border-gray-300 rounded-lg p-4 bg-gray-50 max-h-64 overflow-y-auto">
                    @php $materiYangDiuji = $penguji->materiYangDiuji->pluck('id')->toArray(); @endphp
                    @foreach($materi as $m)
                    <label class="flex items-center gap-2 mb-2 hover:bg-white p-2 rounded cursor-pointer">
                        <input type="checkbox" name="materi_ids[]" value="{{ $m->id }}"
                               {{ in_array($m->id, $materiYangDiuji) ? 'checked' : '' }}
                               class="w-4 h-4 text-hijau-600 border-gray-300 rounded focus:ring-hijau-500">
                        <span class="w-6 h-6 bg-hijau-700 text-white rounded-full text-xs flex items-center justify-center flex-shrink-0">
                            {{ $m->urutan }}
                        </span>
                        <span class="text-sm">{{ $m->nama_materi }}</span>
                    </label>
                    @endforeach
                </div>
                <p class="text-xs text-gray-500 mt-1">Penguji hanya bisa menilai materi yang dipilih di atas</p>
            </div>

            <div class="border-t border-gray-200 pt-4 mt-4">
                <p class="text-sm text-gray-500 mb-3">Kosongkan password jika tidak ingin mengubahnya</p>
                <x-form-input name="password" label="Password Baru" type="password" placeholder="Kosongkan jika tidak diubah"/>
                <x-form-input name="password_confirmation" label="Konfirmasi Password Baru" type="password" placeholder="Ulangi password baru"/>
            </div>

            <div class="flex gap-3 mt-6">
                <button type="submit" class="btn-primary">Update Penguji</button>
                <a href="{{ route('admin.penguji.index') }}" class="btn-outline">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection