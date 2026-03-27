@extends('layouts.app')
@section('title', 'Log Aktivitas')
@section('page-title', 'Log Aktivitas')

@section('content')
<div class="card">
    <div class="flex items-center justify-between mb-4">
        <div>
            <h3 class="text-lg font-bold text-hijau-700">Riwayat Aktivitas Sistem</h3>
            <p class="text-gray-500 text-sm">Total: {{ $logs->total() }} aktivitas tercatat</p>
        </div>
    </div>

    {{-- Filter --}}
    <form method="GET" class="grid grid-cols-2 md:grid-cols-5 gap-3 mb-4 p-4 bg-hijau-50 rounded-lg">
        <select name="user_id" class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-hijau-500">
            <option value="">Semua User</option>
            @foreach($users as $u)
                <option value="{{ $u->id }}" {{ request('user_id') == $u->id ? 'selected' : '' }}>
                    {{ $u->name }}
                </option>
            @endforeach
        </select>

        <select name="role" class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-hijau-500">
            <option value="">Semua Role</option>
            <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
            <option value="lembaga" {{ request('role') == 'lembaga' ? 'selected' : '' }}>Lembaga</option>
            <option value="penguji" {{ request('role') == 'penguji' ? 'selected' : '' }}>Penguji</option>
        </select>

        <input type="text" name="aksi" value="{{ request('aksi') }}" placeholder="Cari aksi..."
               class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-hijau-500">

        <input type="date" name="tanggal_dari" value="{{ request('tanggal_dari') }}"
               class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-hijau-500">

        <input type="date" name="tanggal_sampai" value="{{ request('tanggal_sampai') }}"
               class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-hijau-500">

        <div class="flex gap-2 col-span-2 md:col-span-5">
            <button type="submit" class="btn-primary text-sm px-4 py-2">Filter</button>
            <a href="{{ route('admin.log.index') }}" class="btn-outline text-sm px-4 py-2">Reset</a>
        </div>
    </form>

    {{-- Tabel --}}
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-hijau-700 text-white">
                    <th class="px-3 py-3 text-left rounded-tl-lg">Waktu</th>
                    <th class="px-3 py-3 text-left">User</th>
                    <th class="px-3 py-3 text-left">Role</th>
                    <th class="px-3 py-3 text-left">Aksi</th>
                    <th class="px-3 py-3 text-left">Detail</th>
                    <th class="px-3 py-3 text-left rounded-tr-lg">IP Address</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                <tr class="border-b border-gray-100 hover:bg-hijau-50 transition-colors">
                    <td class="px-3 py-3 text-gray-600 text-xs">
                        {{ $log->created_at->format('d/m/Y H:i') }}
                    </td>
                    <td class="px-3 py-3 font-medium">
                        {{ $log->nama_user ?? '-' }}
                    </td>
                    <td class="px-3 py-3">
                        <span class="bg-hijau-100 text-hijau-700 text-xs px-2 py-1 rounded-full capitalize">
                            {{ $log->role }}
                        </span>
                    </td>
                    <td class="px-3 py-3 font-semibold text-hijau-700">
                        {{ $log->aksi }}
                    </td>
                    <td class="px-3 py-3 text-gray-600 text-xs">
                        {{ $log->detail ?? '-' }}
                    </td>
                    <td class="px-3 py-3 text-gray-500 text-xs font-mono">
                        {{ $log->ip_address ?? '-' }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-4 py-8 text-center text-gray-400">
                        Belum ada aktivitas tercatat
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $logs->links() }}</div>
</div>
@endsection