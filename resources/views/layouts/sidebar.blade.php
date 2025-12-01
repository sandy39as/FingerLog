<div id="sidebar"
     class="w-60 min-h-screen flex flex-col shadow-xl
            bg-blue-900 dark:bg-blue-950 text-white
            fixed sm:static inset-y-0 left-0 transform -translate-x-full sm:translate-x-0
            transition-transform duration-300 z-50">

    {{-- TOP: LOGO + CLOSE BUTTON --}}
    <div class="flex items-center justify-between px-5 py-6 border-b border-blue-800 dark:border-blue-900">

        {{-- LOGO + TEXT --}}
        <div class="flex items-center gap-3">
            <img src="{{ asset('logo finger png.png') }}"
                 class="w-10 h-10 object-contain rounded-lg shadow">

            <div class="leading-tight">
                <h1 class="text-lg font-extrabold tracking-tight">
                    Finger<span class="text-emerald-300">Log</span>
                </h1>
                <p class="text-[11px] text-blue-200 dark:text-blue-300/70">
                    Sistem Absensi
                </p>
            </div>
        </div>

        {{-- CLOSE BUTTON (mobile only) --}}
        <button onclick="closeSidebar()"
                class="sm:hidden text-white text-xl leading-none px-2 hover:text-emerald-300 transition">
            ✕
        </button>
    </div>

    {{-- MENU LIST --}}
    <nav class="flex-1 px-4 py-4 space-y-1 text-sm">

        {{-- Dashboard --}}
        <a href="{{ route('dashboard') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all
                 {{ request()->is('dashboard') 
                    ? 'bg-blue-800 dark:bg-blue-900 text-white shadow-inner font-semibold' 
                    : 'hover:bg-blue-800/70 dark:hover:bg-blue-900/50 text-blue-100' }}">
            <span>📊</span> Dashboard
        </a>

        {{-- Karyawan --}}
        <a href="{{ route('karyawan.index') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all
                 {{ request()->is('karyawan*') 
                    ? 'bg-blue-800 dark:bg-blue-900 text-white shadow-inner font-semibold' 
                    : 'hover:bg-blue-800/70 dark:hover:bg-blue-900/50 text-blue-100' }}">
            <span>👥</span> Karyawan
        </a>

        {{-- Absensi --}}
        <a href="{{ route('absensi.index') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all
                 {{ request()->is('absensi*') 
                    ? 'bg-blue-800 dark:bg-blue-900 text-white shadow-inner font-semibold' 
                    : 'hover:bg-blue-800/70 dark:hover:bg-blue-900/50 text-blue-100' }}">
            <span>📝</span> Absensi
        </a>
    </nav>

</div>
