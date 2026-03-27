@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')

@php $role = Auth::user()->getRoleNames()->first(); @endphp

{{-- Header selamat datang --}}
<div class="card mb-6 bg-gradient-to-r from-hijau-700 to-hijau-600 text-white border-0">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold mb-1">
                السَّلَامُ عَلَيْكُمْ
            </h2>
            <p class="text-hijau-100 text-sm">Selamat datang, <span class="font-semibold">{{ Auth::user()->name }}</span></p>
            <p class="text-hijau-200 text-xs mt-1">{{ now()->translatedFormat('l, d F Y') }}</p>
        </div>
        <div class="opacity-20">
            <svg viewBox="0 0 100 100" class="w-20 h-20 fill-current">
                <path d="M50 10 L53 35 L78 25 L63 45 L88 50 L63 55 L78 75 L53 65 L50 90 L47 65 L22 75 L37 55 L12 50 L37 45 L22 25 L47 35 Z"/>
            </svg>
        </div>
    </div>
</div>

{{-- ===== DASHBOARD ADMIN ===== --}}
@if($role === 'admin')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="card flex items-center gap-4">
        <div class="w-12 h-12 bg-hijau-100 rounded-xl flex items-center justify-center">
            <svg class="w-6 h-6 text-hijau-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5"/>
            </svg>
        </div>
        <div>
            <p class="text-gray-500 text-xs">Total Lembaga</p>
            <p class="text-2xl font-bold text-hijau-700">{{ \App\Models\Lembaga::count() }}</p>
        </div>
    </div>

    <div class="card flex items-center gap-4">
        <div class="w-12 h-12 bg-emas-100 rounded-xl flex items-center justify-center">
            <svg class="w-6 h-6 text-emas-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
        </div>
        <div>
            <p class="text-gray-500 text-xs">Total Peserta</p>
            <p class="text-2xl font-bold text-emas-600">{{ \App\Models\Peserta::count() }}</p>
        </div>
    </div>

    <div class="card flex items-center gap-4">
        <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <div>
            <p class="text-gray-500 text-xs">Nilai Lengkap</p>
            <p class="text-2xl font-bold text-green-600">{{ \App\Models\Peserta::where('status_nilai', 'lengkap')->count() }}</p>
        </div>
    </div>

    <div class="card flex items-center gap-4">
        <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center">
            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <div>
            <p class="text-gray-500 text-xs">Masih Draft</p>
            <p class="text-2xl font-bold text-yellow-600">{{ \App\Models\Peserta::where('status_nilai', 'draft')->count() }}</p>
        </div>
    </div>
</div>
@endif

{{-- ===== DASHBOARD LEMBAGA ===== --}}
@if($role === 'lembaga')
@php $lembagaId = Auth::user()->lembaga_id; @endphp
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <div class="card flex items-center gap-4">
        <div class="w-12 h-12 bg-hijau-100 rounded-xl flex items-center justify-center">
            <svg class="w-6 h-6 text-hijau-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
            </svg>
        </div>
        <div>
            <p class="text-gray-500 text-xs">Total Murid</p>
            <p class="text-2xl font-bold text-hijau-700">{{ \App\Models\Peserta::where('lembaga_id', $lembagaId)->count() }}</p>
        </div>
    </div>
    <div class="card flex items-center gap-4">
        <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <div>
            <p class="text-gray-500 text-xs">Nilai Lengkap</p>
            <p class="text-2xl font-bold text-green-600">{{ \App\Models\Peserta::where('lembaga_id', $lembagaId)->where('status_nilai','lengkap')->count() }}</p>
        </div>
    </div>
    <div class="card flex items-center gap-4">
        <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center">
            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <div>
            <p class="text-gray-500 text-xs">Masih Draft</p>
            <p class="text-2xl font-bold text-yellow-600">{{ \App\Models\Peserta::where('lembaga_id', $lembagaId)->where('status_nilai','draft')->count() }}</p>
        </div>
    </div>
</div>
@endif

{{-- ===== DASHBOARD PENGUJI ===== --}}
@if($role === 'penguji')
<div class="card">
    <h3 class="font-semibold text-hijau-700 mb-3">Notifikasi Terbaru</h3>
    @php $notifs = Auth::user()->notifikasi()->latest()->take(5)->get(); @endphp
    @forelse($notifs as $notif)
        <div class="flex items-start gap-3 py-2 border-b border-gray-100 last:border-0">
            <div class="w-2 h-2 rounded-full mt-2 {{ $notif->is_read ? 'bg-gray-300' : 'bg-emas-500' }} flex-shrink-0"></div>
            <div>
                <p class="text-sm font-medium">{{ $notif->judul }}</p>
                <p class="text-xs text-gray-500">{{ $notif->pesan }}</p>
                <p class="text-xs text-gray-400 mt-1">{{ $notif->created_at->diffForHumans() }}</p>
            </div>
        </div>
    @empty
        <p class="text-gray-400 text-sm text-center py-4">Belum ada notifikasi</p>
    @endforelse
</div>
@endif

@endsection