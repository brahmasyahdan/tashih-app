<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Tashih App') — Penilaian Al-Qur'an</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-krem min-h-screen">

    <div class="flex h-screen overflow-hidden">

        {{-- SIDEBAR --}}
        @include('layouts.sidebar')

        {{-- KONTEN UTAMA --}}
        <div class="flex-1 flex flex-col overflow-hidden">

            {{-- NAVBAR --}}
            @include('layouts.navbar')

            {{-- HALAMAN KONTEN --}}
            <main class="flex-1 overflow-y-auto p-6">

                {{-- Flash Message --}}
                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-800 rounded-lg flex items-center gap-2">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-800 rounded-lg flex items-center gap-2">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm-1-9v4a1 1 0 102 0V9a1 1 0 10-2 0zm0-4a1 1 0 112 0 1 1 0 01-2 0z" clip-rule="evenodd"/>
                        </svg>
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </main>

        </div>
    </div>

</body>
</html>