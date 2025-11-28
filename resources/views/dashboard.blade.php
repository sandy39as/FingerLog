<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-800">Dashboard Finger Log</h1>
        <p class="text-sm text-slate-500 mt-1">
            Ringkasan presensi karyawan hari ini.
        </p>
    </div>

    <div class="space-y-6">

        {{-- KARTU RINGKASAN --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-white border border-slate-200 rounded-xl p-4 shadow-sm">
                <p class="text-xs uppercase tracking-wide text-slate-500">Total Karyawan</p>
                <p class="mt-2 text-2xl font-bold text-slate-800">{{ $totalKaryawan }}</p>
                <p class="text-xs text-slate-500 mt-1">Terdaftar di sistem</p>
            </div>

            <div class="bg-emerald-50 border border-emerald-200 rounded-xl p-4 shadow-sm">
                <p class="text-xs uppercase tracking-wide text-emerald-700">Hadir Hari Ini</p>
                <p class="mt-2 text-2xl font-bold text-emerald-700">{{ $hadirHariIni }}</p>
                <p class="text-xs text-emerald-700 mt-1">
                    {{ \Carbon\Carbon::parse($today)->translatedFormat('d M Y') }}
                </p>
            </div>

            <div class="bg-orange-50 border border-orange-200 rounded-xl p-4 shadow-sm">
                <p class="text-xs uppercase tracking-wide text-orange-700">Terlambat</p>
                <p class="mt-2 text-2xl font-bold text-orange-700">{{ $terlambatHariIni }}</p>
                <p class="text-xs text-orange-700 mt-1">Telat &gt; 0 menit</p>
            </div>

            <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 shadow-sm">
                <p class="text-xs uppercase tracking-wide text-blue-700">Belum Pulang</p>
                <p class="mt-2 text-2xl font-bold text-blue-700">{{ $belumPulang }}</p>
                <p class="text-xs text-blue-700 mt-1">Masih aktif di shift</p>
            </div>
        </div>

        {{-- REKAP ABSEN HARI INI --}}
        <div class="bg-white border border-slate-200 rounded-xl shadow-sm">
            <div class="px-4 py-3 border-b border-slate-200 flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-semibold text-slate-800">
                        Rekap Absensi Hari Ini
                    </h3>
                    <p class="text-xs text-slate-500">
                        {{ \Carbon\Carbon::parse($today)->translatedFormat('l, d F Y') }}
                    </p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-left">
                    <thead class="bg-slate-50 border-b border-slate-200 text-xs uppercase text-slate-500">
                        <tr>
                            <th class="px-4 py-2">Karyawan</th>
                            <th class="px-4 py-2">Departemen</th>
                            <th class="px-4 py-2">Jam Masuk</th>
                            <th class="px-4 py-2">Istirahat</th>
                            <th class="px-4 py-2">Jam Pulang</th>
                            <th class="px-4 py-2 text-center">Telat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($rekapHariIni as $rekap)
                            <tr class="border-b border-slate-100 hover:bg-slate-50">
                                <td class="px-4 py-2">
                                    <div class="font-semibold text-slate-800">
                                        {{ $rekap->karyawan->nama ?? '-' }}
                                    </div>
                                    <div class="text-xs text-slate-500">
                                        ID Finger: {{ $rekap->karyawan->id_finger ?? '-' }}
                                    </div>
                                </td>
                                <td class="px-4 py-2 text-xs text-slate-600">
                                    {{ $rekap->karyawan->departemen->nama ?? '-' }}
                                </td>
                                <td class="px-4 py-2 text-xs text-slate-700">
                                    {{ $rekap->jam_masuk ? \Carbon\Carbon::parse($rekap->jam_masuk)->format('H:i') : '-' }}
                                </td>
                                <td class="px-4 py-2 text-xs text-slate-700">
                                    @if($rekap->jam_istirahat_keluar || $rekap->jam_istirahat_masuk)
                                        {{ $rekap->jam_istirahat_keluar ? \Carbon\Carbon::parse($rekap->jam_istirahat_keluar)->format('H:i') : ' - ' }}
                                        &mdash;
                                        {{ $rekap->jam_istirahat_masuk ? \Carbon\Carbon::parse($rekap->jam_istirahat_masuk)->format('H:i') : ' - ' }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="px-4 py-2 text-xs text-slate-700">
                                    {{ $rekap->jam_pulang ? \Carbon\Carbon::parse($rekap->jam_pulang)->format('H:i') : '-' }}
                                </td>
                                <td class="px-4 py-2 text-xs text-center">
                                    @if ($rekap->telat_menit > 0)
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded-full bg-orange-100 text-orange-700 font-medium">
                                            {{ $rekap->telat_menit }} mnt
                                        </span>
                                    @else
                                        <span class="text-slate-400">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-6 text-center text-sm text-slate-500">
                                    Belum ada data absensi untuk hari ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-4 py-3 border-t border-slate-200 text-xs text-slate-500">
                Data di atas diambil dari tabel <code>absen_harian</code>.
            </div>
        </div>
    </div>
@endsection
