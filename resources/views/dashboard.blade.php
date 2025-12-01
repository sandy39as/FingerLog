@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-6 space-y-6">

    <h1 class="text-2xl font-bold mb-2">Dashboard Absensi - {{ $today }}</h1>

    {{-- Kartu ringkasan --}}
    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4">
        <div class="bg-white border border-slate-200 rounded-xl p-4 shadow-sm">
            <p class="text-xs uppercase tracking-wide text-slate-500">Total Karyawan</p>
            <p class="mt-2 text-2xl font-bold text-slate-800">{{ $totalKaryawan }}</p>
        </div>

        <div class="bg-emerald-50 border border-emerald-200 rounded-xl p-4 shadow-sm">
            <p class="text-xs uppercase tracking-wide text-emerald-700">Hadir Hari Ini</p>
            <p class="mt-2 text-2xl font-bold text-emerald-900">{{ $hadirHariIni }}</p>
        </div>

        <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 shadow-sm">
            <p class="text-xs uppercase tracking-wide text-amber-700">Terlambat (orang)</p>
            <p class="mt-2 text-2xl font-bold text-amber-900">{{ $terlambatHariIni }}</p>
            <p class="text-xs text-amber-800 mt-1">Total {{ $totalMenitTelatHariIni }} menit</p>
        </div>

        <div class="bg-indigo-50 border border-indigo-200 rounded-xl p-4 shadow-sm">
            <p class="text-xs uppercase tracking-wide text-indigo-700">Lembur (orang)</p>
            <p class="mt-2 text-2xl font-bold text-indigo-900">{{ $lemburHariIni }}</p>
            <p class="text-xs text-indigo-800 mt-1">Total {{ $totalMenitLemburHariIni }} menit</p>
        </div>

        <div class="bg-rose-50 border border-rose-200 rounded-xl p-4 shadow-sm md:col-span-2 lg:col-span-1">
            <p class="text-xs uppercase tracking-wide text-rose-700">Belum Pulang</p>
            <p class="mt-2 text-2xl font-bold text-rose-900">{{ $belumPulang }}</p>
        </div>
    </div>

    {{-- Tabel detail hari ini --}}
    <div class="bg-white shadow rounded p-4">
        <h2 class="text-lg font-semibold mb-3">Detail Absensi Hari Ini</h2>

        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-100 text-gray-700">
                    <th class="p-2">Nama</th>
                    <th class="p-2">Shift</th>
                    <th class="p-2">Masuk</th>
                    <th class="p-2">Istirahat</th>
                    <th class="p-2">Masuk Lagi</th>
                    <th class="p-2">Pulang</th>
                    <th class="p-2">Telat</th>
                    <th class="p-2">Lembur</th>
                    <th class="p-2">Keterangan</th>
                    <th class="p-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($rekap as $r)
                    <tr class="border-b">
                        <td class="p-2">{{ $r->karyawan->nama }}</td>
                        <td class="p-2">{{ $r->shift->nama_shift ?? '-' }}</td>
                        <td class="p-2">{{ $r->jam_masuk }}</td>
                        <td class="p-2">{{ $r->jam_istirahat_mulai }}</td>
                        <td class="p-2">{{ $r->jam_istirahat_selesai }}</td>
                        <td class="p-2">{{ $r->jam_pulang }}</td>
                        <td class="p-2 {{ $r->status_telat ? 'text-red-600 font-bold' : '' }}">
                            {{ $r->status_telat ? $r->menit_telat . ' mnt' : '-' }}
                        </td>
                        <td class="p-2 {{ $r->status_lembur ? 'text-blue-600 font-bold' : '' }}">
                            {{ $r->status_lembur ? $r->menit_lembur . ' mnt' : '-' }}
                        </td>
                        <td class="p-2 text-xs">{{ $r->keterangan }}</td>
                        <td class="p-2">
                            <a href="{{ route('absensi.edit', $r->id) }}"
                               class="px-2 py-1 text-xs bg-yellow-500 text-white rounded">
                                Edit
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="p-4 text-center text-gray-500">
                            Belum ada data absensi untuk hari ini.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-3">
            {{ $rekap->links() }}
        </div>
    </div>
</div>
@endsection
