@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 py-8 space-y-6">

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
            <h2 class="text-2xl font-extrabold text-slate-800 dark:text-slate-100">
                Rekap Absensi
            </h2>
            <p class="text-sm text-slate-500 dark:text-slate-400">
                Proses dan kelola rekap absensi karyawan per tanggal.
            </p>
        </div>

        <span class="inline-flex items-center px-3 py-1 rounded-full
                     bg-emerald-50 dark:bg-emerald-900/30
                     text-emerald-700 dark:text-emerald-300
                     text-xs font-semibold border border-emerald-200 dark:border-emerald-800">
            ● Rekap Harian Fingerprint
        </span>
    </div>

    {{-- FLASH MESSAGE --}}
    @if (session('success'))
        <div class="animate-fade-in-up bg-emerald-50 dark:bg-emerald-900/30
                    border border-emerald-200 dark:border-emerald-800
                    text-emerald-800 dark:text-emerald-200
                    text-sm px-4 py-2.5 rounded-xl flex items-center gap-2">
            <span class="text-lg">✅</span>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    {{-- KARTU ATAS: PROSES & IMPORT --}}
    <div class="grid md:grid-cols-2 gap-4 animate-fade-in-up" style="animation-delay:.05s">

        {{-- CARD PROSES REKAP --}}
        <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl shadow-sm p-4">
            <h3 class="text-sm font-semibold text-slate-800 dark:text-slate-100 mb-1">
                Proses Rekap Absensi
            </h3>
            <p class="text-xs text-slate-500 dark:text-slate-400 mb-3">
                Pilih tanggal untuk memproses rekap absensi dari log fingerprint.
            </p>

            <form action="{{ route('absensi.proses') }}" method="post"
                  class="flex flex-col sm:flex-row sm:items-center gap-3">
                @csrf

                <div>
                    <label class="block text-xs font-semibold text-slate-700 dark:text-slate-200 mb-1">
                        Tanggal Rekap
                    </label>
                    <input type="date"
                           name="tanggal"
                           value="{{ date('Y-m-d') }}"
                           class="border border-slate-300 dark:border-slate-600
                                  rounded-lg px-3 py-1.5 text-sm
                                  bg-white dark:bg-slate-800
                                  text-slate-800 dark:text-slate-100
                                  focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:border-emerald-400">
                </div>

                <button type="submit"
                        class="inline-flex items-center px-4 py-2 mt-1 sm:mt-5 rounded-lg text-xs font-semibold
                               bg-emerald-600 text-white shadow-sm hover:bg-emerald-700 transition">
                    Proses Rekap
                </button>
            </form>
        </div>

        {{-- CARD IMPORT EXCEL --}}
        <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl shadow-sm p-4">
            <h3 class="text-sm font-semibold text-slate-800 dark:text-slate-100 mb-1">
                Import Excel Finger
            </h3>
            <p class="text-xs text-slate-500 dark:text-slate-400 mb-3">
                Upload file Excel dari mesin fingerprint untuk diolah menjadi rekap absensi.
            </p>

            <form action="{{ route('absensi.import') }}" method="post" enctype="multipart/form-data"
                  class="space-y-3">
                @csrf

                <div>
                    <label class="block text-xs font-semibold text-slate-700 dark:text-slate-200 mb-1">
                        File Excel
                    </label>
                    <input type="file" name="file"
                           class="block w-full text-xs
                                  file:mr-3 file:py-1.5 file:px-3
                                  file:rounded-lg file:border-0 file:text-xs file:font-semibold
                                  file:bg-slate-100 dark:file:bg-slate-700
                                  file:text-slate-700 dark:file:text-slate-100
                                  hover:file:bg-slate-200 dark:hover:file:bg-slate-600
                                  cursor-pointer text-slate-800 dark:text-slate-100">
                    <p class="text-[11px] text-slate-400 dark:text-slate-500 mt-1">
                        Format: .xlsx, .xls, .csv
                    </p>
                </div>

                <button type="submit"
                        class="inline-flex items-center px-4 py-2 rounded-lg text-xs font-semibold
                               bg-blue-600 text-white shadow-sm hover:bg-blue-700 transition">
                    Upload
                </button>
            </form>
        </div>
    </div>

    {{-- CARD TABEL REKAP --}}
    <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl shadow-sm p-5 animate-fade-in-up" style="animation-delay:.1s">

        {{-- Header atas tabel + Export --}}
        <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between mb-3">
            <div>
                <h3 class="text-base font-semibold text-slate-800 dark:text-slate-100">
                    Daftar Rekap Absensi
                </h3>
                <p class="text-xs text-slate-500 dark:text-slate-400">
                    Menampilkan rekap absensi lengkap: jam masuk, istirahat, pulang, telat, dan lembur.
                </p>
            </div>

            {{-- FORM EXPORT EXCEL --}}
            <form action="{{ route('absensi.export') }}" method="get"
                  class="flex flex-col sm:flex-row sm:items-center gap-2 text-xs">
                <label class="font-semibold text-slate-600 dark:text-slate-300">
                    Export Rekap Tanggal
                </label>
                <input type="date"
                       name="tanggal"
                       value="{{ request('tanggal', date('Y-m-d')) }}"
                       class="border border-slate-300 dark:border-slate-600
                              rounded-lg px-3 py-1.5 text-xs
                              bg-white dark:bg-slate-800
                              text-slate-800 dark:text-slate-100
                              focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400">
                <button type="submit"
                        class="px-3 py-1.5 bg-indigo-600 text-white rounded-lg text-xs font-semibold shadow-sm hover:bg-indigo-700 transition">
                    Export Excel
                </button>
            </form>
        </div>

        {{-- TABLE --}}
        <div class="overflow-x-auto rounded-xl border border-slate-100 dark:border-slate-700/70">
            <table class="min-w-full text-xs sm:text-sm">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-900/60 text-slate-600 dark:text-slate-300 text-[11px] uppercase">
                        <th class="px-3 py-2 text-left">Nama</th>
                        <th class="px-3 py-2 text-left">Tanggal</th>
                        <th class="px-3 py-2 text-left">Shift</th>
                        <th class="px-3 py-2 text-left">Masuk</th>
                        <th class="px-3 py-2 text-left">Istirahat</th>
                        <th class="px-3 py-2 text-left">Masuk Lagi</th>
                        <th class="px-3 py-2 text-left">Pulang</th>
                        <th class="px-3 py-2 text-left">Telat</th>
                        <th class="px-3 py-2 text-left">Lembur</th>
                        <th class="px-3 py-2 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100 dark:divide-slate-700/70">
                    @forelse ($rekap as $r)
                        <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-700/60 transition-colors">
                            <td class="px-3 py-2 text-slate-800 dark:text-slate-100">
                                {{ $r->karyawan->nama }}
                            </td>
                            <td class="px-3 py-2 text-slate-700 dark:text-slate-200">
                                {{ $r->tanggal }}
                            </td>
                            <td class="px-3 py-2 text-slate-700 dark:text-slate-200">
                                {{ $r->shift->nama_shift ?? '-' }}
                            </td>

                            <td class="px-3 py-2 text-slate-700 dark:text-slate-200">
                                {{ $r->jam_masuk ?? '-' }}
                            </td>
                            <td class="px-3 py-2 text-slate-700 dark:text-slate-200">
                                {{ $r->jam_istirahat_mulai ?? '-' }}
                            </td>
                            <td class="px-3 py-2 text-slate-700 dark:text-slate-200">
                                {{ $r->jam_istirahat_selesai ?? '-' }}
                            </td>
                            <td class="px-3 py-2 text-slate-700 dark:text-slate-200">
                                {{ $r->jam_pulang ?? '-' }}
                            </td>

                            <td class="px-3 py-2">
                                @if ($r->status_telat)
                                    <span class="inline-flex items-center px-2 py-1 rounded-full
                                                 bg-red-50 dark:bg-red-900/40
                                                 border border-red-100 dark:border-red-800
                                                 text-[11px] text-red-700 dark:text-red-300 font-semibold">
                                        Telat {{ $r->menit_telat }} mnt
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-1 rounded-full
                                                 bg-emerald-50 dark:bg-emerald-900/40
                                                 border border-emerald-100 dark:border-emerald-800
                                                 text-[11px] text-emerald-700 dark:text-emerald-300 font-semibold">
                                        Tepat waktu
                                    </span>
                                @endif
                            </td>

                            <td class="px-3 py-2">
                                @if ($r->status_lembur)
                                    <span class="inline-flex items-center px-2 py-1 rounded-full
                                                 bg-blue-50 dark:bg-blue-900/40
                                                 border border-blue-100 dark:border-blue-800
                                                 text-[11px] text-blue-700 dark:text-blue-300 font-semibold">
                                        {{ $r->menit_lembur }} mnt
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-1 rounded-full
                                                 bg-slate-50 dark:bg-slate-900/40
                                                 border border-slate-100 dark:border-slate-700
                                                 text-[11px] text-slate-500 dark:text-slate-300">
                                        -
                                    </span>
                                @endif
                            </td>

                            <td class="px-3 py-2 text-center">
                                <a href="{{ route('absensi.edit', $r->id) }}"
                                   class="inline-flex items-center px-3 py-1.5 text-[11px] font-semibold
                                          bg-amber-500 hover:bg-amber-600 text-white rounded-full shadow-sm transition">
                                    Edit
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="px-4 py-6 text-center text-slate-500 dark:text-slate-400 text-sm">
                                Belum ada data absensi untuk ditampilkan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        <div class="mt-4">
            {{ $rekap->links() }}
        </div>
    </div>
</div>
@endsection
