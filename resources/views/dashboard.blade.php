@extends('layouts.app')

@section('content')
    {{-- HEADER --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-800">Dashboard Presensi</h1>
        <p class="text-sm text-slate-500 mt-1">
            Ringkasan kehadiran karyawan pabrik berdasarkan data fingerprint.
        </p>
    </div>

    <div class="space-y-6">

        {{-- KARTU RINGKASAN --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            {{-- Total Karyawan --}}
            <div class="bg-white border border-slate-200 rounded-xl p-4 shadow-sm">
                <p class="text-xs uppercase tracking-wide text-slate-500">Total Karyawan</p>
                <p class="mt-2 text-2xl font-bold text-slate-800">{{ $totalKaryawan }}</p>
                <p class="text-xs text-slate-500 mt-1">Terdaftar di sistem</p>
            </div>

            {{-- Hadir Hari Ini --}}
            <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 shadow-sm">
                <p class="text-xs uppercase tracking-wide text-blue-700">Hadir Hari Ini</p>
                <p class="mt-2 text-2xl font-bold text-blue-700">{{ $hadirHariIni }}</p>
                <p class="text-xs text-blue-700 mt-1">
                    {{ \Carbon\Carbon::parse($today)->translatedFormat('d M Y') }}
                </p>
            </div>

            {{-- Terlambat --}}
            <div class="bg-orange-50 border border-orange-200 rounded-xl p-4 shadow-sm">
                <p class="text-xs uppercase tracking-wide text-orange-700">Terlambat</p>
                <p class="mt-2 text-2xl font-bold text-orange-700">{{ $terlambatHariIni }}</p>
                <p class="text-xs text-orange-700 mt-1">Telat &gt; 0 menit</p>
            </div>

            {{-- Belum Pulang --}}
            <div class="bg-emerald-50 border border-emerald-200 rounded-xl p-4 shadow-sm">
                <p class="text-xs uppercase tracking-wide text-emerald-700">Belum Pulang</p>
                <p class="mt-2 text-2xl font-bold text-emerald-700">{{ $belumPulang }}</p>
                <p class="text-xs text-emerald-700 mt-1">Masih aktif di shift</p>
            </div>
        </div>

        {{-- ROW: GRAFIK + INFO RINGKAS --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Grafik Kehadiran 7 Hari --}}
            <div class="bg-white border border-slate-200 rounded-xl shadow-sm p-4 lg:col-span-2">
                <div class="flex items-center justify-between mb-3">
                    <div>
                        <h2 class="text-sm font-semibold text-slate-800">
                            Grafik Kehadiran 7 Hari Terakhir
                        </h2>
                        <p class="text-xs text-slate-500">
                            Berdasarkan jumlah karyawan yang melakukan absen masuk.
                        </p>
                    </div>
                </div>

                <div class="h-64">
                    <canvas id="chartHadir7Hari"></canvas>
                </div>

                @if(empty($chartLabels))
                    <p class="mt-4 text-xs text-slate-400">
                        Belum ada data absensi yang bisa ditampilkan. Import data fingerprint terlebih dahulu.
                    </p>
                @endif
            </div>

            {{-- Info Cepat --}}
            <div class="space-y-3">
                <div class="bg-white border border-slate-200 rounded-xl shadow-sm p-4">
                    <h3 class="text-sm font-semibold text-slate-800 mb-2">Ringkasan Hari Ini</h3>
                    <ul class="text-xs text-slate-600 space-y-1">
                        <li>• Total karyawan: <span class="font-semibold">{{ $totalKaryawan }}</span></li>
                        <li>• Hadir: <span class="font-semibold text-blue-700">{{ $hadirHariIni }}</span></li>
                        <li>• Terlambat: <span class="font-semibold text-orange-700">{{ $terlambatHariIni }}</span></li>
                        <li>• Belum pulang: <span class="font-semibold text-emerald-700">{{ $belumPulang }}</span></li>
                    </ul>
                </div>

                <div class="bg-blue-900 text-blue-50 rounded-xl shadow-sm p-4">
                    <h3 class="text-sm font-semibold mb-1">Tips</h3>
                    <p class="text-xs text-blue-100">
                        Import data fingerprint secara rutin (harian) agar dashboard selalu menampilkan
                        kondisi terkini presensi karyawan.
                    </p>
                </div>
            </div>
        </div>

        {{-- ROW: Aktivitas Terbaru --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            {{-- Aktivitas Fingerprint Terbaru --}}
            <div class="bg-white border border-slate-200 rounded-xl shadow-sm">
                <div class="px-4 py-3 border-b border-slate-200 flex items-center justify-between">
                    <div>
                        <h3 class="text-sm font-semibold text-slate-800">
                            Aktivitas Fingerprint Terbaru
                        </h3>
                        <p class="text-xs text-slate-500">
                            10 log terakhir dari mesin fingerprint.
                        </p>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm text-left">
                        <thead class="bg-slate-50 border-b border-slate-200 text-xs uppercase text-slate-500">
                            <tr>
                                <th class="px-4 py-2">Waktu</th>
                                <th class="px-4 py-2">ID Finger</th>
                                <th class="px-4 py-2">Jenis</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($recentLogs as $log)
                                <tr class="border-b border-slate-100 hover:bg-slate-50">
                                    <td class="px-4 py-2 text-xs text-slate-700">
                                        {{ \Carbon\Carbon::parse($log->tanggal_waktu)->format('d/m H:i') }}
                                    </td>
                                    <td class="px-4 py-2 text-xs font-mono text-slate-800">
                                        {{ $log->id_finger }}
                                    </td>
                                    <td class="px-4 py-2 text-xs text-slate-700">
                                        @php
                                            $jenis = [
                                                1 => 'Absen Datang',
                                                2 => 'Keluar Istirahat',
                                                3 => 'Selesai Istirahat',
                                                4 => 'Absen Pulang',
                                            ][$log->jenis_absen ?? 0] ?? '-';
                                        @endphp
                                        {{ $jenis }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-4 py-6 text-center text-sm text-slate-500">
                                        Belum ada data aktivitas fingerprint yang diimport.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Placeholder: nanti bisa diganti rekap shift / departemen --}}
            <div class="bg-white border border-slate-200 rounded-xl shadow-sm p-4">
                <h3 class="text-sm font-semibold text-slate-800 mb-2">
                    Rekap Shift (Coming Soon)
                </h3>
                <p class="text-xs text-slate-500 mb-3">
                    Setelah fitur shift & pengolahan absensi selesai dibuat, bagian ini akan menampilkan
                    ringkasan per shift (Shift 1, 2, 3) termasuk jumlah hadir, telat, dan lembur.
                </p>

                <div class="border border-dashed border-slate-200 rounded-lg p-4 text-xs text-slate-400">
                    Fitur ini akan aktif setelah tabel <code>shift_kerja</code> dan <code>absen_harian</code>
                    terisi dari proses pengolahan data fingerprint.
                </div>
            </div>

        </div>

    </div>

    {{-- Chart.js via CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        (function () {
            const labels = JSON.parse(`@json($chartLabels)`);
            const data   = JSON.parse(`@json($chartData)`);


            const ctx = document.getElementById('chartHadir7Hari');
            if (ctx && labels.length > 0) {
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Hadir',
                            data: data,
                            borderWidth: 2,
                            tension: 0.3,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    precision: 0
                                }
                            }
                        }
                    }
                });
            }
        })();
    </script>
@endsection
