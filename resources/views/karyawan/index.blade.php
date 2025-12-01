{{-- resources/views/dashboard.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 py-8 space-y-6">

    {{-- Animasi sederhana --}}
    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(6px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .animate-fade-in-up {
            animation: fadeInUp 0.35s ease-out forwards;
        }
    </style>

    {{-- HEADER --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 animate-fade-in-up">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-800 dark:text-slate-100">
                Data Karyawan
            </h1>
            <p class="text-sm text-slate-500 dark:text-slate-400">
                Kelola dan import data karyawan dari file Excel.
            </p>
        </div>

        <span class="inline-flex items-center px-3 py-1 rounded-full
                     bg-emerald-50 dark:bg-emerald-900/30
                     text-emerald-700 dark:text-emerald-300
                     text-xs font-semibold border border-emerald-200 dark:border-emerald-800">
            ● Master Data Karyawan
        </span>
    </div>

    {{-- ALERT (opsional) --}}
    @if (session('success'))
        <div class="animate-fade-in-up rounded-xl border border-emerald-200 dark:border-emerald-800
                    bg-emerald-50 dark:bg-emerald-900/30 px-4 py-3 text-sm text-emerald-800 dark:text-emerald-200">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="animate-fade-in-up rounded-xl border border-rose-200 dark:border-rose-800
                    bg-rose-50 dark:bg-rose-900/30 px-4 py-3 text-sm text-rose-800 dark:text-rose-200">
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- CARD IMPORT --}}
    <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700
                rounded-2xl shadow-sm p-5 animate-fade-in-up" style="animation-delay:.05s">
        <h2 class="text-base font-semibold text-slate-800 dark:text-slate-100 mb-1">
            Import Excel Karyawan Asli
        </h2>
        <p class="text-xs text-slate-500 dark:text-slate-400 mb-4">
            Upload file Excel yang berisi data karyawan untuk diimpor ke sistem.
        </p>

        <form action="{{ route('karyawan.import') }}" method="post" enctype="multipart/form-data"
              class="flex flex-col sm:flex-row sm:items-end gap-4">
            @csrf

            <div class="w-full sm:w-auto">
                <label class="block text-xs font-semibold text-slate-700 dark:text-slate-200 mb-1">
                    Pilih File Excel
                </label>
                <input type="file" name="file"
                       class="block w-full text-sm
                              file:mr-3 file:py-1.5 file:px-3
                              file:rounded-lg file:border-0 file:text-xs file:font-semibold
                              file:bg-emerald-50 file:text-emerald-700
                              hover:file:bg-emerald-100 cursor-pointer
                              text-slate-800 dark:text-slate-100">
                <p class="text-[11px] text-slate-400 dark:text-slate-500 mt-1">
                    Format yang didukung: .xlsx, .xls, .csv
                </p>
            </div>

            <button type="submit"
                    class="inline-flex items-center px-4 py-2.5 rounded-lg text-sm font-semibold
                           bg-emerald-600 text-white shadow-sm hover:bg-emerald-700 transition">
                Upload &amp; Import
            </button>
        </form>
    </div>

    {{-- CARD TABEL + SEARCH / FILTER --}}
    <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700
                rounded-2xl shadow-sm animate-fade-in-up" style="animation-delay:.1s">

        {{-- Header card --}}
        <div class="px-5 pt-4 pb-3 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-base font-semibold text-slate-800 dark:text-slate-100">
                    Daftar Karyawan
                </h2>
                <p class="text-xs text-slate-500 dark:text-slate-400">
                    Total: <span class="font-semibold">{{ $karyawans->total() }}</span> karyawan
                </p>
            </div>

            {{-- Search + Filter --}}
            <form method="GET" action="{{ route('karyawan.index') }}"
                  class="flex flex-col sm:flex-row gap-2 sm:items-center">

                {{-- Input search nama --}}
                <div class="flex items-center gap-2">
                    <label class="hidden sm:block text-xs text-slate-500 dark:text-slate-400">Cari:</label>
                    <input type="text"
                           name="search"
                           value="{{ request('search') }}"
                           placeholder="Cari nama karyawan..."
                           class="w-full sm:w-52 rounded-lg border border-slate-300 dark:border-slate-600
                                  bg-white dark:bg-slate-800
                                  px-3 py-1.5 text-sm text-slate-800 dark:text-slate-100
                                  focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:border-emerald-400">
                </div>

                {{-- Select bagian --}}
                <div class="flex items-center gap-2">
                    <label class="hidden sm:block text-xs text-slate-500 dark:text-slate-400">Bagian:</label>
                    <select name="bagian"
                            class="w-full sm:w-40 rounded-lg border border-slate-300 dark:border-slate-600
                                   bg-white dark:bg-slate-800
                                   px-3 py-1.5 text-sm text-slate-800 dark:text-slate-100
                                   focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:border-emerald-400">
                        <option value="">Semua Bagian</option>
                        @foreach ($bagianOptions as $bagian)
                            <option value="{{ $bagian }}"
                                {{ request('bagian') == $bagian ? 'selected' : '' }}>
                                {{ $bagian }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Tombol reset & submit --}}
                <div class="flex gap-2 justify-end">
                    @if(request('search') || request('bagian'))
                        <a href="{{ route('karyawan.index') }}"
                           class="px-3 py-1.5 rounded-lg border border-slate-300 dark:border-slate-600
                                  text-xs text-slate-600 dark:text-slate-200
                                  bg-white dark:bg-slate-800 hover:bg-slate-50 dark:hover:bg-slate-700">
                            Reset
                        </a>
                    @endif

                    <button type="submit"
                            class="px-4 py-1.5 rounded-lg bg-emerald-600 text-white text-xs font-semibold hover:bg-emerald-700">
                        Terapkan
                    </button>
                </div>
            </form>
        </div>

        <div class="border-t border-slate-100 dark:border-slate-700/70"></div>

        {{-- Tabel --}}
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-900/60 text-slate-600 dark:text-slate-300 text-xs uppercase">
                        <th class="px-4 py-2 text-left font-semibold">Nama</th>
                        <th class="px-4 py-2 text-left font-semibold">Bagian</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-700/70">
                    @forelse ($karyawans as $karyawan)
                        <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-700/60 transition-colors">
                            <td class="px-4 py-2 text-slate-800 dark:text-slate-100">
                                {{ $karyawan->nama }}
                            </td>
                            <td class="px-4 py-2 text-slate-700 dark:text-slate-200">
                                {{ $karyawan->bagian ?? '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="px-4 py-6 text-center text-slate-500 dark:text-slate-400 text-sm">
                                Belum ada data karyawan atau tidak ditemukan hasil untuk filter saat ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        <div class="px-5 py-4 border-t border-slate-100 dark:border-slate-700/70">
            {{ $karyawans->appends(request()->only('search', 'bagian'))->links() }}
        </div>
    </div>
</div>
@endsection
