{{-- Overlay mobile --}}
<div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-20 hidden lg:hidden" onclick="toggleSidebar()">
</div>

{{-- Sidebar --}}
<aside id="sidebar" class="fixed lg:static inset-y-0 left-0 z-30 w-64 
              bg-hijau-700 text-white flex flex-col 
              transform -translate-x-full lg:translate-x-0 
              transition-transform duration-300 ease-in-out">

    {{-- Logo & Judul --}}
    <div class="p-5 border-b border-hijau-600">
        {{-- Ornamen Islami SVG --}}
        <div class="flex items-center gap-3 mb-1">
            <div class="w-10 h-10 bg-emas-500 rounded-lg flex items-center justify-center shadow-md">
                <svg viewBox="0 0 40 40" class="w-7 h-7 text-white fill-current">
                    <path
                        d="M20 4 L22 14 L32 10 L26 18 L36 20 L26 22 L32 30 L22 26 L20 36 L18 26 L8 30 L14 22 L4 20 L14 18 L8 10 L18 14 Z" />
                </svg>
            </div>
            <div>
                <h1 class="font-bold text-lg leading-tight">Tashih App</h1>
                <p class="text-hijau-200 text-xs">Penilaian Al-Qur'an</p>
            </div>
        </div>
    </div>

    {{-- Info User --}}
    <div class="px-4 py-3 bg-hijau-800 border-b border-hijau-600">
        <p class="text-sm font-semibold truncate">{{ Auth::user()->name }}</p>
        <span class="text-xs bg-emas-500 text-white px-2 py-0.5 rounded-full capitalize">
            {{ Auth::user()->getRoleNames()->first() ?? 'user' }}
        </span>
    </div>

    {{-- Menu Navigasi --}}
    <nav class="flex-1 overflow-y-auto py-4 px-3">

        @php $role = Auth::user()->getRoleNames()->first(); @endphp

        {{-- ===== MENU ADMIN ===== --}}
        @if($role === 'admin')
            <x-sidebar-item href="{{ route('dashboard') }}" icon="home" label="Dashboard" />

            <p class="text-hijau-300 text-xs font-semibold uppercase tracking-wider px-3 mt-4 mb-1">Master Data</p>
            <x-sidebar-item href="{{ route('admin.lembaga.index') }}" icon="building" label="Lembaga" />
            <x-sidebar-item href="{{ route('admin.penguji.index') }}" icon="users" label="Penguji" />
            <x-sidebar-item href="{{ route('admin.materi.index') }}" icon="book" label="Materi Ujian" />

            <p class="text-hijau-300 text-xs font-semibold uppercase tracking-wider px-3 mt-4 mb-1">Penilaian</p>
            <x-sidebar-item href="{{ route('admin.peserta.index') }}" icon="list" label="Data Peserta" />
            <x-sidebar-item href="{{ route('admin.nilai.index') }}" icon="star" label="Rekap Nilai" />

            <p class="text-hijau-300 text-xs font-semibold uppercase tracking-wider px-3 mt-4 mb-1">Laporan</p>
            <x-sidebar-item href="{{ route('admin.laporan.index') }}" icon="print" label="Cetak Laporan" />
            <x-sidebar-item href="{{ route('admin.import-export.index') }}" icon="folder" label="Import/Export" />

            <p class="text-hijau-300 text-xs font-semibold uppercase tracking-wider px-3 mt-4 mb-1">Sistem</p>
            <x-sidebar-item href="{{ route('admin.log.index') }}" icon="log" label="Log Aktivitas" />
        @endif

        {{-- ===== MENU LEMBAGA ===== --}}
        @if($role === 'lembaga')
            <x-sidebar-item href="{{ route('dashboard') }}" icon="home" label="Dashboard" />
            <x-sidebar-item href="{{ route('lembaga.peserta.index') }}" icon="list" label="Data Murid" />
            <x-sidebar-item href="{{ route('lembaga.import-export.index') }}" icon="folder" label="Import/Export" />
            <x-sidebar-item href="{{ route('lembaga.nilai.index') }}" icon="star" label="Nilai Murid" />
        @endif

        {{-- ===== MENU PENGUJI ===== --}}
        @if($role === 'penguji')
            <x-sidebar-item href="{{ route('dashboard') }}" icon="home" label="Dashboard" />
            <x-sidebar-item href="{{ route('penguji.nilai.index') }}" icon="star" label="Input Nilai" />
            <x-sidebar-item href="{{ route('penguji.notifikasi.index') }}" icon="bell" label="Notifikasi" />
        @endif

    </nav>

    {{-- Tombol Logout --}}
    <div class="p-4 border-t border-hijau-600">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full flex items-center gap-2 px-3 py-2 rounded-lg
                           text-hijau-200 hover:bg-hijau-600 hover:text-white 
                           transition-colors duration-200 text-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                Keluar
            </button>
        </form>
    </div>

</aside>