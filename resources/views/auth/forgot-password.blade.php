<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-slate-100 dark:bg-slate-900 px-4">

        {{-- CARD FORGOT PASSWORD --}}
        <div class="w-full max-w-sm bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700
                    rounded-2xl shadow-lg p-6 animate-fade-in-up">

            {{-- Logo + Title --}}
            <div class="text-center mb-5">
                <img src="{{ asset('logo finger png.png') }}" class="w-16 h-16 mx-auto mb-2">
                <h1 class="text-xl font-bold text-slate-800 dark:text-slate-100">
                    Reset Password
                </h1>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                    Masukkan email Anda, kami akan kirim link untuk mengganti password.
                </p>
            </div>

            {{-- Session Status --}}
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
                @csrf

                {{-- Email Address --}}
                <div>
                    <x-input-label for="email" :value="__('Email')" class="dark:text-slate-200" />

                    <x-text-input id="email"
                                  class="block mt-1 w-full dark:bg-slate-700 dark:border-slate-600 dark:text-slate-100"
                                  type="email"
                                  name="email"
                                  :value="old('email')"
                                  required autofocus />

                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                {{-- Actions --}}
                <div class="flex items-center justify-between pt-1">
                    <a href="{{ route('login') }}"
                       class="text-xs text-slate-600 hover:text-slate-900 dark:text-slate-300 dark:hover:text-slate-100 underline">
                        Kembali ke login
                    </a>

                    <x-primary-button class="bg-emerald-600 hover:bg-emerald-700 dark:bg-emerald-700 dark:hover:bg-emerald-600">
                        {{ __('Email Password Reset Link') }}
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
