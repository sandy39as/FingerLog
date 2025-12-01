<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-slate-100 dark:bg-slate-900 px-4">

        {{-- CARD LOGIN --}}
        <div class="w-full max-w-sm bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 
                    rounded-2xl shadow-lg p-6 animate-fade-in-up">

            {{-- Logo --}}
            <div class="text-center mb-5">
                <img src="{{ asset('logo finger png.png') }}" class="w-16 h-16 mx-auto mb-2">
                <h1 class="text-xl font-bold text-slate-800 dark:text-slate-100">Masuk ke FingerLog</h1>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Silakan login untuk melanjutkan</p>
            </div>

            {{-- Session Status --}}
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                {{-- Email --}}
                <div>
                    <x-input-label for="email" :value="__('Email')" class="dark:text-slate-200" />

                    <x-text-input id="email"
                                  type="email"
                                  name="email"
                                  :value="old('email')"
                                  required autofocus autocomplete="username"
                                  class="block mt-1 w-full dark:bg-slate-700 dark:border-slate-600 dark:text-slate-100" />

                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                {{-- Password --}}
                <div>
                    <x-input-label for="password" :value="__('Password')" class="dark:text-slate-200" />

                    <x-text-input id="password"
                                  type="password"
                                  name="password"
                                  required autocomplete="current-password"
                                  class="block mt-1 w-full dark:bg-slate-700 dark:border-slate-600 dark:text-slate-100" />

                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                {{-- Remember Me --}}
                <div class="flex items-center mt-1">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox"
                               class="rounded border-gray-300 text-indigo-600 shadow-sm 
                                      focus:ring-indigo-500 dark:bg-slate-700 dark:border-slate-600"
                               name="remember">
                        <span class="ml-2 text-sm text-slate-600 dark:text-slate-300">{{ __('Remember me') }}</span>
                    </label>
                </div>

                {{-- Buttons --}}
                <div class="flex items-center justify-between pt-1">

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}"
                           class="text-xs text-slate-600 hover:text-slate-900 dark:text-slate-300 dark:hover:text-slate-100 underline">
                            Lupa password?
                        </a>
                    @endif

                    <x-primary-button class="ml-3 bg-emerald-600 hover:bg-emerald-700 dark:bg-emerald-700 dark:hover:bg-emerald-600">
                        {{ __('Log in') }}
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
