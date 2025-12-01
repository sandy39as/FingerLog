<header 
    class="bg-white dark:bg-slate-800 h-16 shadow flex items-center justify-between px-4 sm:px-6"
    x-data="{ openUserMenu: false }">

    {{-- KIRI: HAMBURGER + TITLE --}}
    <div class="flex items-center gap-3">

        {{-- HAMBURGER BUTTON (mobile only) --}}
        <button
            type="button"
            class="sm:hidden inline-flex items-center justify-center w-9 h-9 rounded-lg border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-100 bg-white dark:bg-slate-700 hover:bg-slate-50 dark:hover:bg-slate-600 transition"
            onclick="window.toggleSidebar && window.toggleSidebar()">
            ☰
        </button>

        {{-- TITLE --}}
        <div class="hidden sm:flex flex-col leading-tight">
            <span class="text-sm font-semibold text-slate-800 dark:text-slate-100">
                ㅤ</span>
            </span>
            <span class="text-[11px] text-slate-400 dark:text-slate-400">
                ㅤ
            </span>
        </div>
    </div>

    {{-- KANAN: DARK MODE + USER --}}
    <div class="flex items-center gap-3">

        {{-- TOGGLE DARK MODE --}}
        <button
            @click="
                dark = !dark;
                if (dark) {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('theme', 'dark');
                } else {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('theme', 'light');
                }
            "
            class="w-9 h-9 rounded-full border border-slate-200 dark:border-slate-600 flex items-center justify-center text-lg bg-white dark:bg-slate-700 text-amber-400 dark:text-yellow-300 shadow-sm hover:bg-slate-50 dark:hover:bg-slate-600 transition"
            :title="dark ? 'Mode terang' : 'Mode gelap'">
            <span x-show="!dark">🌙</span>
            <span x-show="dark">☀️</span>
        </button>

        {{-- USER + DROPDOWN --}}
        <div class="relative">
            <button 
                @click="openUserMenu = !openUserMenu"
                class="flex items-center space-x-3 focus:outline-none"
            >
                <div class="text-right">
                    <p class="text-sm font-medium text-slate-800 dark:text-slate-100 leading-none">
                        {{ Auth::user()->name ?? 'User' }}
                    </p>
                </div>

                <div class="w-9 h-9 rounded-full bg-blue-200 dark:bg-blue-500 flex items-center justify-center text-sm font-semibold text-blue-900 dark:text-white">
                    {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                </div>
            </button>

            <div
                x-show="openUserMenu"
                @click.outside="openUserMenu = false"
                x-transition
                class="absolute right-0 mt-2 w-48 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg shadow-lg py-2 z-50"
            >
                <a href="{{ route('profile.edit') }}"
                   class="block px-4 py-2 text-sm text-slate-700 dark:text-slate-100 hover:bg-slate-100 dark:hover:bg-slate-700">
                    Profil
                </a>

                <div class="border-t border-slate-200 dark:border-slate-700 my-2"></div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button
                        type="submit"
                        class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 dark:hover:bg-red-900/40"
                    >
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>

</header>
