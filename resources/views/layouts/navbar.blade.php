<header class="bg-white border-b border-emas-200 shadow-sm px-6 py-3 flex items-center justify-between">

    {{-- Tombol toggle sidebar (mobile) --}}
    <button onclick="toggleSidebar()" 
            class="lg:hidden text-hijau-700 hover:text-hijau-900">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
    </button>

    {{-- Judul Halaman --}}
    <h2 class="text-hijau-700 font-semibold text-lg hidden lg:block">
        @yield('page-title', 'Dashboard')
    </h2>

    {{-- Kanan: Notifikasi + Profil --}}
    <div class="flex items-center gap-4 ml-auto">

        {{-- Bell Notifikasi --}}
        <div class="relative">
            <a href="#" class="relative text-hijau-600 hover:text-hijau-800 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>
                @php
                    $unreadCount = Auth::user()->notifikasi()->where('is_read', false)->count();
                @endphp
                @if($unreadCount > 0)
                    <span class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 text-white 
                                 text-xs rounded-full flex items-center justify-center font-bold">
                        {{ $unreadCount > 9 ? '9+' : $unreadCount }}
                    </span>
                @endif
            </a>
        </div>

        {{-- Profil User --}}
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 bg-hijau-700 rounded-full flex items-center justify-center">
                <span class="text-white text-sm font-bold">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </span>
            </div>
            <span class="text-sm font-medium text-gray-700 hidden md:block">
                {{ Auth::user()->name }}
            </span>
        </div>

    </div>
</header>

<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');
        sidebar.classList.toggle('-translate-x-full');
        overlay.classList.toggle('hidden');
    }
</script>