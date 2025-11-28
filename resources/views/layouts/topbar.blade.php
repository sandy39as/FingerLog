<header 
    class="bg-white h-16 shadow flex items-center justify-between px-6"
    x-data="{ openUserMenu: false }"
>
    {{-- SEARCH --}}
    <div class="w-72">
        <input type="text"
               class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm"
               placeholder="Search...">
    </div>

    {{-- USER + DROPDOWN --}}
    <div class="relative">
        {{-- TRIGGER --}}
        <button 
            @click="openUserMenu = !openUserMenu"
            class="flex items-center space-x-3 focus:outline-none"
        >
            <div class="text-right">
                <p class="text-sm font-medium text-slate-800 leading-none">
                    {{ Auth::user()->name ?? 'User' }}
                </p>
                <p class="text-xs text-slate-500 mt-0.5">
                    IT Admin
                </p>
            </div>

            <div class="w-9 h-9 rounded-full bg-blue-200 flex items-center justify-center text-sm font-semibold text-blue-900">
                {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
            </div>
        </button>

        {{-- DROPDOWN MENU --}}
        <div
            x-show="openUserMenu"
            @click.outside="openUserMenu = false"
            x-transition
            class="absolute right-0 mt-2 w-48 bg-white border border-slate-200 rounded-lg shadow-lg py-2 z-50"
        >
            <a href="{{ route('profile.edit') }}"
               class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-100">
                Profil
            </a>

            <div class="border-t my-2"></div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button
                    type="submit"
                    class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50"
                >
                    Logout
                </button>
            </form>
        </div>
    </div>

</header>
