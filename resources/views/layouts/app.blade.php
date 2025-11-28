<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $title ?? 'Sistem Presensi Karyawan' }}</title>

    {{-- FONT ROBOTO --}}
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">

    {{-- VITE ASSETS --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-100 font-roboto">

    <div class="flex min-h-screen">

        {{-- 🌐 SIDEBAR --}}
        @include('layouts.sidebar')

        {{-- AREA KANAN (NAVBAR + CONTENT + FOOTER) --}}
        <div class="flex-1 flex flex-col min-h-screen">

            {{-- 🌐 TOPBAR --}}
            @include('layouts.topbar')

            {{-- 🌐 MAIN CONTENT --}}
            <main class="flex-1 p-6">
                @yield('content')
            </main>

            {{-- 🌐 FOOTER --}}
            @include('layouts.footer')

        </div>

    </div>

</body>
</html>
