<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-slate-100 dark:bg-slate-900 px-4">

        {{-- CARD REGISTER --}}
        <div class="w-full max-w-sm bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 
                    rounded-2xl shadow-lg p-6 animate-fade-in-up">

            {{-- Logo + Title --}}
            <div class="text-center mb-5">
                <img src="{{ asset('logo finger png.png') }}" class="w-16 h-16 mx-auto mb-2">
                <h1 class="text-xl font-bold text-slate-800 dark:text-slate-100">
                    Daftar Admin FingerLog
                </h1>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                    Buat akun admin untuk mengelola absensi.
                </p>
            </div>

            {{-- Error global (optional) --}}
            @if ($errors->any())
                <div class="mb-3 text-xs text-rose-600 dark:text-rose-300">
                    Terdapat beberapa error, periksa kembali data yang diisi.
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf

                {{-- Name --}}
                <div>
                    <x-input-label for="name" :value="__('Name')" class="dark:text-slate-200" />
                    <x-text-input id="name"
                                  class="block mt-1 w-full dark:bg-slate-700 dark:border-slate-600 dark:text-slate-100"
                                  type="text"
                                  name="name"
                                  :value="old('name')"
                                  required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                {{-- Email --}}
                <div>
                    <x-input-label for="email" :value="__('Email')" class="dark:text-slate-200" />
                    <x-text-input id="email"
                                  class="block mt-1 w-full dark:bg-slate-700 dark:border-slate-600 dark:text-slate-100"
                                  type="email"
                                  name="email"
                                  :value="old('email')"
                                  required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                {{-- Password --}}
                <div>
                    <x-input-label for="password" :value="__('Password')" class="dark:text-slate-200" />
                    <x-text-input id="password"
                                  class="block mt-1 w-full dark:bg-slate-700 dark:border-slate-600 dark:text-slate-100"
                                  type="password"
                                  name="password"
                                  required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                {{-- Confirm Password --}}
                <div>
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="dark:text-slate-200" />
                    <x-text-input id="password_confirmation"
                                  class="block mt-1 w-full dark:bg-slate-700 dark:border-slate-600 dark:text-slate-100"
                                  type="password"
                                  name="password_confirmation"
                                  required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                {{-- Footer: link ke login + tombol daftar --}}
                <div class="flex items-center justify-between pt-1">
                    <a href="{{ route('login') }}"
                       class="text-xs text-slate-600 hover:text-slate-900 dark:text-slate-300 dark:hover:text-slate-100 underline">
                        {{ __('Already registered?') }}
                    </a>

                    <x-primary-button class="ml-3 bg-emerald-600 hover:bg-emerald-700 dark:bg-emerald-700 dark:hover:bg-emerald-600">
                        {{ __('Register') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>

    {{-- Simple fade-in animation --}}
    <style>
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(10px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in-up { animation: fadeInUp .4s ease-out; }
    </style>
</x-guest-layout>
