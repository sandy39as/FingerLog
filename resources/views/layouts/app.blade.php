<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      x-data="{ dark: localStorage.getItem('theme') === 'dark' }"
      x-init="if (dark) document.documentElement.classList.add('dark')">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $title ?? 'Finger Log' }}</title>
    <link rel="icon" type="image/png" href="{{ asset('logo finger png.png') }}">

    {{-- FONT ROBOTO --}}
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">

    {{-- VITE ASSETS --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

{{-- ✨ PERHATIKAN BAGIAN INI --}}
<body class="font-roboto text-slate-900 dark:text-slate-100
             bg-slate-100 dark:bg-slate-950">

    {{-- OVERLAY SIDEBAR (mobile) --}}
    <div id="sidebarOverlay"
         onclick="closeSidebar()"
         class="fixed inset-0 bg-black/40 z-40 hidden sm:hidden"></div>

    <div class="flex min-h-screen">

        {{-- SIDEBAR --}}
        @include('layouts.sidebar')

        {{-- AREA KANAN (TOPBAR + CONTENT + FOOTER) --}}
        <div class="flex-1 flex flex-col min-h-screen">
            {{-- Topbar ikut dark-mode di file topbar.blade.php --}}
            @include('layouts.topbar')

            {{-- MAIN CONTENT --}}
            <main class="flex-1 p-4 sm:p-6">
                @yield('content')
            </main>

            {{-- FOOTER --}}
            @include('layouts.footer')
        </div>
    </div>

    {{-- SCRIPT TOGGLE SIDEBAR --}}
    <script>
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');

        window.toggleSidebar = function () {
            if (!sidebar || !overlay) return;
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }

        window.closeSidebar = function () {
            if (!sidebar || !overlay) return;
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        }
    </script>
</body>
</html>
