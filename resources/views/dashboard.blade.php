@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 py-6 space-y-6">

    @php
        $tepatWaktu = max($hadirHariIni - $terlambatHariIni, 0);
        $belumAbsen = max($totalKaryawan - $hadirHariIni, 0);
    @endphp

    {{-- Animasi sederhana --}}
    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(8px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .animate-fade-in-up {
            animation: fadeInUp 0.4s ease-out forwards;
        }
    </style>

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 animate-fade-in-up">

        {{-- Judul + Date Picker --}}
        <div class="space-y-2 w-full sm:w-auto">
            <h1 class="text-xl sm:text-2xl font-extrabold text-slate-800 dark:text-slate-100 leading-tight">
                Dashboard Absensi
            </h1>

            {{-- Date Picker --}}
            <form method="GET" action="{{ route('absensi.dashboard') }}"
                  class="flex flex-col sm:flex-row sm:items-center gap-2 mt-1
                         bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700
                         px-3 py-2 rounded-xl shadow-sm hover:shadow transition w-full sm:w-auto">

                <div class="flex items-center gap-2">
                    <span class="text-xs font-semibold text-slate-600 dark:text-slate-200 whitespace-nowrap">
                        Tanggal:
                    </span>

                    <input type="date"
                           name="tanggal"
                           value="{{ request('tanggal', $today) }}"
                           class="border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800
                                  text-xs sm:text-sm text-slate-800 dark:text-slate-100 rounded-lg px-2 py-1.5
                                  w-full sm:w-auto focus:ring-emerald-400 focus:border-emerald-400 transition">
                </div>

                <button type="submit"
                        class="px-3 py-1.5 text-xs sm:text-sm bg-emerald-600 text-white rounded-lg shadow
                               hover:bg-emerald-700 transition font-medium w-full sm:w-auto text-center">
                    Tampilkan
                </button>
            </form>
        </div>

        {{-- Badge Status --}}
        <span class="inline-flex items-center justify-center px-4 py-2 rounded-xl
                     bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300
                     text-xs sm:text-sm font-semibold border border-emerald-200 dark:border-emerald-800
                     shadow-sm w-full sm:w-auto">
            ● Monitoring Kehadiran
        </span>

    </div>

    {{-- Kartu ringkasan --}}
    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-3 gap-4">

        {{-- Total Karyawan --}}
        <div class="bg-gradient-to-br from-white to-slate-50 dark:from-slate-800 dark:to-slate-900
                    border border-slate-200 dark:border-slate-700 rounded-2xl p-4 shadow-sm 
                    hover:shadow-md transition-all duration-200 transform hover:-translate-y-0.5 animate-fade-in-up">
            <div class="flex items-center justify-between gap-3">
                <div>
                    <p class="text-[11px] uppercase tracking-wide text-slate-500 dark:text-slate-400">
                        Total Karyawan
                    </p>
                    <p class="mt-2 text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-slate-50 leading-none">
                        {{ $totalKaryawan }}
                    </p>
                    <p class="mt-1 text-[11px] text-slate-500 dark:text-slate-400">
                        Terdaftar dalam sistem
                    </p>
                </div>
                <div class="shrink-0 w-10 h-10 rounded-full bg-slate-100 dark:bg-slate-700 flex items-center justify-center text-lg">
                    👥
                </div>
            </div>
        </div>

        {{-- Hadir Hari Ini --}}
        <div class="bg-gradient-to-br from-emerald-50 to-emerald-100/70 dark:from-emerald-900/40 dark:to-emerald-900/10
                    border border-emerald-200 dark:border-emerald-800 rounded-2xl p-4 shadow-sm 
                    hover:shadow-md transition-all duration-200 transform hover:-translate-y-0.5 animate-fade-in-up"
             style="animation-delay:.05s">
            <div class="flex items-center justify-between gap-3">
                <div>
                    <p class="text-[11px] uppercase tracking-wide text-emerald-700 dark:text-emerald-300">
                        Hadir Hari Ini
                    </p>
                    <p class="mt-2 text-2xl sm:text-3xl font-extrabold text-emerald-900 dark:text-emerald-100 leading-none">
                        {{ $hadirHariIni }}
                    </p>
                    <p class="mt-1 text-[11px] text-emerald-800 dark:text-emerald-200">
                        Karyawan yang sudah absen masuk
                    </p>
                </div>
                <div class="shrink-0 w-10 h-10 rounded-full bg-emerald-100 dark:bg-emerald-900 flex items-center justify-center text-lg">
                    ✅
                </div>
            </div>
        </div>

        {{-- Terlambat --}}
        <div class="bg-gradient-to-br from-amber-50 to-amber-100/70 dark:from-amber-900/40 dark:to-amber-900/10
                    border border-amber-200 dark:border-amber-800 rounded-2xl p-4 shadow-sm 
                    hover:shadow-md transition-all duration-200 transform hover:-translate-y-0.5 animate-fade-in-up"
             style="animation-delay:.1s">
            <div class="flex items-center justify-between gap-3">
                <div>
                    <p class="text-[11px] uppercase tracking-wide text-amber-700 dark:text-amber-300">
                        Terlambat (orang)
                    </p>
                    <p class="mt-2 text-2xl sm:text-3xl font-extrabold text-amber-900 dark:text-amber-100 leading-none">
                        {{ $terlambatHariIni }}
                    </p>
                    <p class="mt-1 text-[11px] text-amber-800 dark:text-amber-200">
                        Total {{ $totalMenitTelatHariIni }} menit keterlambatan
                    </p>
                </div>
                <div class="shrink-0 w-10 h-10 rounded-full bg-amber-100 dark:bg-amber-900 flex items-center justify-center text-lg">
                    ⏰
                </div>
            </div>
        </div>

    </div>

    {{-- Ringkasan + Grafik --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 animate-fade-in-up" style="animation-delay:.18s">

        {{-- Grafik Donut --}}
        <div class="lg:col-span-2 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl p-4 sm:p-5 shadow-sm">
            <div class="flex items-center justify-between mb-3">
                <div>
                    <h2 class="text-sm sm:text-base font-semibold text-slate-800 dark:text-slate-100">
                        Komposisi Kehadiran Hari Ini
                    </h2>
                    <p class="text-[11px] sm:text-xs text-slate-500 dark:text-slate-400">
                        Perbandingan karyawan tepat waktu, terlambat, dan belum absen.
                    </p>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row sm:items-center gap-4">
                <div class="sm:w-1/2">
                    <canvas id="absensiDonut"></canvas>
                </div>

                <div class="flex-1 space-y-2 text-xs sm:text-sm">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-emerald-500"></span>
                            <span class="text-slate-700 dark:text-slate-200">Tepat Waktu</span>
                        </div>
                        <span class="font-semibold text-slate-900 dark:text-slate-50">
                            {{ $tepatWaktu }} org
                        </span>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-amber-500"></span>
                            <span class="text-slate-700 dark:text-slate-200">Terlambat</span>
                        </div>
                        <span class="font-semibold text-slate-900 dark:text-slate-50">
                            {{ $terlambatHariIni }} org
                        </span>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-slate-500"></span>
                            <span class="text-slate-700 dark:text-slate-200">Belum Absen</span>
                        </div>
                        <span class="font-semibold text-slate-900 dark:text-slate-50">
                            {{ $belumAbsen }} org
                        </span>
                    </div>

                    <div class="pt-2 border-t border-slate-100 dark:border-slate-700/70 flex items-center justify-between text-[11px] text-slate-500 dark:text-slate-400">
                        <span>Total karyawan</span>
                        <span class="font-semibold text-slate-900 dark:text-slate-100">{{ $totalKaryawan }} org</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Ringkasan Angka --}}
        <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl p-4 sm:p-5 shadow-sm">
            <h2 class="text-sm sm:text-base font-semibold text-slate-800 dark:text-slate-100 mb-3">
                Ringkasan Angka
            </h2>

            <dl class="space-y-2 text-xs sm:text-sm">
                <div class="flex items-center justify-between">
                    <dt class="text-slate-500 dark:text-slate-400">Total Karyawan</dt>
                    <dd class="font-semibold text-slate-900 dark:text-slate-50">{{ $totalKaryawan }}</dd>
                </div>
                <div class="flex items-center justify-between">
                    <dt class="text-slate-500 dark:text-slate-400">Hadir Hari Ini</dt>
                    <dd class="font-semibold text-emerald-600 dark:text-emerald-300">{{ $hadirHariIni }}</dd>
                </div>
                <div class="flex items-center justify-between">
                    <dt class="text-slate-500 dark:text-slate-400">Tepat Waktu</dt>
                    <dd class="font-semibold text-slate-900 dark:text-slate-50">{{ $tepatWaktu }}</dd>
                </div>
                <div class="flex items-center justify-between">
                    <dt class="text-slate-500 dark:text-slate-400">Terlambat</dt>
                    <dd class="font-semibold text-amber-600 dark:text-amber-300">{{ $terlambatHariIni }}</dd>
                </div>
                <div class="flex items-center justify-between">
                    <dt class="text-slate-500 dark:text-slate-400">Total Menit Telat</dt>
                    <dd class="font-semibold text-amber-600 dark:text-amber-300">{{ $totalMenitTelatHariIni }} mnt</dd>
                </div>
                <div class="flex items-center justify-between">
                    <dt class="text-slate-500 dark:text-slate-400">Belum Pulang</dt>
                    <dd class="font-semibold text-rose-600 dark:text-rose-300">{{ $belumPulang }}</dd>
                </div>
                <div class="flex items-center justify-between">
                    <dt class="text-slate-500 dark:text-slate-400">Belum Absen</dt>
                    <dd class="font-semibold text-slate-700 dark:text-slate-200">{{ $belumAbsen }}</dd>
                </div>
            </dl>
        </div>

    </div>

    {{-- Tabel detail hari ini --}}
    <div class="bg-white dark:bg-slate-800 shadow-sm border border-slate-200 dark:border-slate-700 rounded-2xl p-4 sm:p-5 animate-fade-in-up" style="animation-delay: .2s">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 mb-4">
            <h2 class="text-base sm:text-lg font-semibold text-slate-800 dark:text-slate-100">
                Detail Absensi Hari Ini
            </h2>
            <p class="text-[11px] sm:text-xs text-slate-500 dark:text-slate-400">
                Menampilkan kehadiran karyawan lengkap dengan status keterlambatan.
            </p>
        </div>

        <div class="overflow-x-auto rounded-xl border border-slate-100 dark:border-slate-700/60">
            <table class="min-w-full text-xs sm:text-sm text-left">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-900/60 text-slate-600 dark:text-slate-300 text-[11px] sm:text-xs uppercase">
                        <th class="px-3 py-2 sm:px-4 sm:py-3">Nama</th>
                        <th class="px-3 py-2 sm:px-4 sm:py-3">Shift</th>
                        <th class="px-3 py-2 sm:px-4 sm:py-3">Masuk</th>
                        <th class="px-3 py-2 sm:px-4 sm:py-3">Istirahat</th>
                        <th class="px-3 py-2 sm:px-4 sm:py-3">Masuk Lagi</th>
                        <th class="px-3 py-2 sm:px-4 sm:py-3">Pulang</th>
                        <th class="px-3 py-2 sm:px-4 sm:py-3">Telat</th>
                        <th class="px-3 py-2 sm:px-4 sm:py-3">Keterangan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-700/60">
                    @forelse ($rekap as $r)
                        <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-700/60 transition-colors">
                            <td class="px-3 py-2 sm:px-4 sm:py-3 text-slate-800 dark:text-slate-100 font-medium">
                                {{ $r->karyawan->nama }}
                            </td>
                            <td class="px-3 py-2 sm:px-4 sm:py-3 text-slate-700 dark:text-slate-200">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-[10px] sm:text-[11px]
                                             bg-indigo-50 dark:bg-indigo-900/40 text-indigo-700 dark:text-indigo-200
                                             border border-indigo-100 dark:border-indigo-800">
                                    {{ $r->shift->nama_shift ?? 'Tidak ada shift' }}
                                </span>
                            </td>
                            <td class="px-3 py-2 sm:px-4 sm:py-3 text-slate-700 dark:text-slate-200">
                                {{ $r->jam_masuk ?? '-' }}
                            </td>
                            <td class="px-3 py-2 sm:px-4 sm:py-3 text-slate-700 dark:text-slate-200">
                                {{ $r->jam_istirahat_mulai ?? '-' }}
                            </td>
                            <td class="px-3 py-2 sm:px-4 sm:py-3 text-slate-700 dark:text-slate-200">
                                {{ $r->jam_istirahat_selesai ?? '-' }}
                            </td>
                            <td class="px-3 py-2 sm:px-4 sm:py-3 text-slate-700 dark:text-slate-200">
                                {{ $r->jam_pulang ?? '-' }}
                            </td>
                            <td class="px-3 py-2 sm:px-4 sm:py-3">
                                @if ($r->status_telat)
                                    <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full
                                                 bg-red-50 dark:bg-red-900/40 text-red-700 dark:text-red-300
                                                 border border-red-100 dark:border-red-800
                                                 text-[10px] sm:text-[11px] font-semibold">
                                        ● Telat {{ $r->menit_telat }} mnt
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-1 rounded-full
                                                 bg-emerald-50 dark:bg-emerald-900/40 text-emerald-700 dark:text-emerald-300
                                                 border border-emerald-100 dark:border-emerald-800
                                                 text-[10px] sm:text-[11px] font-semibold">
                                        ✔ Tepat waktu
                                    </span>
                                @endif
                            </td>
                            <td class="px-3 py-2 sm:px-4 sm:py-3 text-[10px] sm:text-xs text-slate-600 dark:text-slate-300">
                                {{ $r->keterangan ?: '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-4 py-6 text-center text-slate-500 dark:text-slate-400 text-sm">
                                Belum ada data absensi untuk hari ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-4">
            {{ $rekap->links() }}
        </div>
    </div>
</div>

{{-- Script Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('absensiDonut');
        if (!ctx) return;

        const dataValues = {
            tepat: {{ $tepatWaktu }},
            telat: {{ $terlambatHariIni }},
            belum: {{ $belumAbsen }},
        };

        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Tepat Waktu', 'Terlambat', 'Belum Absen'],
                datasets: [{
                    data: [dataValues.tepat, dataValues.telat, dataValues.belum],
                    borderWidth: 1,
                    backgroundColor: [
                        '#22c55e', // hijau
                        '#f97316', // oranye
                        '#64748b', // slate
                    ]
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: false,
                    }
                },
                cutout: '60%'
            }
        });
    });
</script>
@endsection
