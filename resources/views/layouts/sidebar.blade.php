<div class="w-60 bg-blue-900 text-white min-h-screen px-4 py-6">

    {{-- LOGO --}}
    <h1 class="text-xl font-bold mb-8 tracking-wide">PRESENSI</h1>

    {{-- MENU --}}
    <nav class="space-y-2">

        {{-- Dashboard --}}
        <a href="{{ route('dashboard') }}"
           class="flex items-center gap-3 px-3 py-2 rounded-md
                  {{ request()->routeIs('dashboard') ? 'bg-blue-800 text-white' : 'text-blue-100 hover:bg-blue-800/70' }}">
            <span class="w-5 h-5">
                {{-- icon home --}}
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"
                     class="w-5 h-5">
                    <path d="M3 11.5 12 4l9 7.5" />
                    <path d="M5 10.5V20h14v-9.5" />
                </svg>
            </span>
            <span>Dashboard</span>
        </a>

         {{-- Data Karyawan --}}
        <a href="{{ route('karyawan.index') }}"
           class="flex items-center gap-3 px-3 py-2 rounded-md
                  {{ request()->routeIs('karyawan.*') ? 'bg-blue-800 text-white' : 'text-blue-100 hover:bg-blue-800/70' }}">
            <span class="w-5 h-5">
                {{-- icon users --}}
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"
                     class="w-5 h-5">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                    <circle cx="9" cy="7" r="3" />
                    <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                    <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                </svg>
            </span>
            <span>Data Karyawan</span>
        </a>

        {{-- Absen Mentah --}}
        <a href="{{ route('absen-mentah.index') }}"
        class="flex items-center gap-3 px-3 py-2 rounded-md
                {{ request()->routeIs('absen-mentah.*') ? 'bg-blue-800 text-white' : 'text-blue-100 hover:bg-blue-800/70' }}">
            <span class="w-5 h-5">
                {{-- icon list/log --}}
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"
                    class="w-5 h-5">
                    <path d="M8 6h13" />
                    <path d="M8 12h13" />
                    <path d="M8 18h13" />
                    <circle cx="3" cy="6" r="1" />
                    <circle cx="3" cy="12" r="1" />
                    <circle cx="3" cy="18" r="1" />
                </svg>
            </span>
            <span>Absen Mentah</span>
        </a>


        {{-- Absen Harian --}}
        <a href="{{ route('absen-harian.index') }}"
            class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-blue-800 transition
            {{ request()->routeIs('absen-harian.*') ? 'bg-blue-800 text-white' : '' }}">
            
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                 stroke="currentColor" stroke-width="2" stroke-linecap="round">
                <path d="M4 6h16M4 12h16M4 18h16"/>
            </svg>

            Absen Harian
        </a>

       {{-- Shift --}}
        <a href="{{ route('shift.index') }}"
            class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-blue-800 transition">
            
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                 stroke="currentColor" stroke-width="2" stroke-linecap="round">
                <circle cx="12" cy="12" r="4"/>
                <path d="M12 2v2m0 16v2m10-10h-2M4 12H2m15.364-7.364l-1.414 1.414M7.05 16.95l-1.414 1.414m0-13.414L7.05 7.05m9.192 9.192l1.414 1.414"/>
            </svg>

            Shift Kerja
        </a>

        {{-- Departemen --}}
        <a href="{{ route('departemen.index') }}"
        class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-blue-800 transition
                {{ request()->routeIs('departemen.*') ? 'bg-blue-800 text-white' : 'text-blue-100' }}">
            <span class="w-5 h-5">
                {{-- icon building --}}
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"
                    class="w-5 h-5">
                    <rect x="3" y="3" width="7" height="18" />
                    <rect x="14" y="7" width="7" height="14" />
                    <path d="M7 7h0M7 11h0M7 15h0M18 11h0M18 15h0" />
                </svg>
            </span>
            <span>Departemen</span>
        </a>

        <!-- <a href="/import"
           class="block px-3 py-2 rounded-md hover:bg-blue-800 transition">
            Import Data
        </a> -->

    </nav>

</div>
