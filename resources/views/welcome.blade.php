<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Finger Log</title>

    {{-- Tailwind CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        navy: {
                            light: "#1D2F45",
                            DEFAULT: "#0E1A2B",
                            dark: "#0A1523"
                        },
                        emerald: {
                            soft: "#6EE7B7",
                            DEFAULT: "#10B981"
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'system-ui'],
                    }
                },
            },
        };
    </script>
</head>

<body class="bg-slate-100 text-slate-800 font-sans">

    {{-- TOP NAV --}}
    <header class="bg-white shadow-sm border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">

            {{-- LOGO --}}
            <div class="flex items-center gap-3">
                <div class="h-12 w-12 rounded-xl bg-navy text-white flex items-center justify-center overflow-hidden border border-emerald-soft">
                    <img src="{{ asset('logo finger png.png') }}" class="max-h-10 max-w-10 object-contain">
                </div>

                <div>
                    <h1 class="text-lg font-semibold text-navy">
                        Finger Log
                    </h1>
                    <p class="text-xs text-emerald font-medium tracking-wide">
                        Sistem Absensi Fingerprint
                    </p>
                </div>
            </div>

            {{-- NAVIGATION --}}
            <nav class="flex items-center gap-2 text-sm">
                @auth
                    <a href="/dashboard"
                        class="px-4 py-2 rounded-full bg-emerald text-white font-medium shadow-md hover:bg-emerald-soft transition">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}"
                        class="px-4 py-2 rounded-full border border-slate-300 text-slate-700 hover:bg-slate-100 transition">
                        Log In
                    </a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                            class="px-4 py-2 rounded-full bg-emerald text-white font-medium shadow-md hover:bg-emerald-soft transition">
                            Register Admin
                        </a>
                    @endif
                @endauth
            </nav>
        </div>
    </header>

    {{-- MAIN SECTION --}}
    <main class="max-w-7xl mx-auto px-6 py-12 grid md:grid-cols-2 gap-12 items-center">

        {{-- LEFT TEXT --}}
        <div>
            <h2 class="text-4xl font-bold text-navy leading-tight">
                Pantau Riwayat <span class="text-emerald">Finger</span> Karyawan Secara
                <span class="text-emerald">Akurat</span> & Realtime.
            </h2>

            <p class="mt-4 text-slate-600 text-lg">
                Finger Log mengubah data <strong>absen mentah</strong> dari mesin fingerprint menjadi
                <strong>rekap harian</strong> yang mudah dibaca: jam masuk, istirahat, pulang, telat,
                dan lembur.
            </p>

            <div class="flex flex-wrap gap-2 mt-5">
                <span class="px-3 py-1 bg-white border border-slate-300 rounded-full text-xs font-semibold text-slate-700">
                    Rekap Harian
                </span>
                <span class="px-3 py-1 bg-white border border-slate-300 rounded-full text-xs font-semibold text-slate-700">
                    Log Finger
                </span>
                <span class="px-3 py-1 bg-white border border-slate-300 rounded-full text-xs font-semibold text-slate-700">
                    Shift & Departemen
                </span>
            </div>

            <div class="mt-6 flex gap-4 items-center">
                @auth
                    <a href="/dashboard"
                        class="px-6 py-3 bg-emerald text-white rounded-lg text-sm font-semibold shadow-lg hover:bg-emerald-soft transition">
                        Buka Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}"
                        class="px-6 py-3 bg-emerald text-white rounded-lg text-sm font-semibold shadow-lg hover:bg-emerald-soft transition">
                        Login Admin
                    </a>
                @endauth
            </div>
        </div>

        {{-- RIGHT CARD --}}
        <div class="bg-white rounded-2xl shadow-xl border border-slate-200 p-6">

            <h3 class="text-sm uppercase font-semibold tracking-wide text-slate-500 mb-4">
                Ringkasan Hari Ini
            </h3>

            <div class="grid grid-cols-2 gap-4 mb-6">

                {{-- CARD 1 --}}
                <div class="bg-slate-50 border border-slate-200 rounded-xl p-4">
                    <p class="text-xs text-slate-500 uppercase tracking-wide">Total Karyawan</p>
                    <h4 class="text-2xl font-bold text-navy">128</h4>
                    <p class="text-xs text-slate-500 mt-1">Aktif di sistem</p>
                </div>

                {{-- CARD 2 --}}
                <div class="bg-emerald-soft/80 border border-emerald rounded-xl p-4">
                    <p class="text-xs text-emerald-900 uppercase tracking-wide">Hadir</p>
                    <h4 class="text-2xl font-bold text-emerald-900">117</h4>
                    <p class="text-xs text-emerald-900 mt-1">+5 dari kemarin</p>
                </div>

                {{-- CARD 3 --}}
                <div class="bg-orange-50 border border-orange-200 rounded-xl p-4">
                    <p class="text-xs text-orange-700 uppercase tracking-wide">Terlambat</p>
                    <h4 class="text-2xl font-bold text-orange-700">11</h4>
                    <p class="text-xs text-orange-700 mt-1">Shift pagi</p>
                </div>

                {{-- CARD 4 --}}
                <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
                    <p class="text-xs text-blue-700 uppercase tracking-wide">Belum Pulang</p>
                    <h4 class="text-2xl font-bold text-blue-700">39</h4>
                    <p class="text-xs text-blue-700 mt-1">Masih aktif</p>
                </div>

            </div>

            {{-- NAVIGATION SHORTCUTS --}}
            <div class="grid grid-cols-3 gap-4 text-center text-xs">

                <a class="p-3 rounded-xl border border-slate-200 bg-slate-50 hover:border-emerald hover:bg-emerald-soft/40 transition cursor-pointer">
                    <p class="font-semibold">Riwayat</p>
                    <p class="text-slate-600 text-[0.7rem]">Log Mentah</p>
                </a>

                <a class="p-3 rounded-xl border border-slate-200 bg-slate-50 hover:border-emerald hover:bg-emerald-soft/40 transition cursor-pointer">
                    <p class="font-semibold">Karyawan</p>
                    <p class="text-slate-600 text-[0.7rem]">Departemen</p>
                </a>

                <a class="p-3 rounded-xl border border-slate-200 bg-slate-50 hover:border-emerald hover:bg-emerald-soft/40 transition cursor-pointer">
                    <p class="font-semibold">Import</p>
                    <p class="text-slate-600 text-[0.7rem]">File Finger</p>
                </a>

            </div>

        </div>
    </main>

    {{-- FOOTER --}}
    <footer class="text-center py-4 text-xs text-slate-500">
        © {{ date('Y') }} Finger Log — Sistem Absensi Fingerprint Berbasis Laravel.
    </footer>

</body>

</html>
