@extends('layouts.app')

@section('content')
    <div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-slate-800">Rekap Absen Harian</h1>
        <p class="text-sm text-slate-500 mt-1">
            Rekap hasil olahan dari data absen mentah.
        </p>
    </div>

    <div class="flex items-center gap-2">
        {{-- Form Proses Ulang --}}
        <form action="{{ route('absen-harian.proses') }}" method="POST" class="flex items-center gap-2">
            @csrf
            <input type="date" name="tanggal"
                   value="{{ $tanggal }}"
                   class="border border-slate-300 rounded-lg px-2 py-1 text-sm">
            <button class="px-4 py-2 text-sm bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                Proses Ulang
            </button>
        </form>

        {{-- Tombol Export Excel --}}
        <a href="{{ route('absen-harian.export', ['tanggal' => $tanggal]) }}"
           class="px-4 py-2 text-sm bg-emerald-600 text-white rounded-lg hover:bg-emerald-700">
            Download Excel
        </a>
    </div>
</div>


    @if (session('success'))
        <div class="mb-4 px-4 py-2 text-sm text-emerald-800 bg-emerald-50 border border-emerald-200 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-x-auto">
        <table class="min-w-full text-sm text-left">
            <thead class="bg-slate-50 border-b border-slate-200 text-xs uppercase text-slate-500">
                <tr>
                    <th class="px-4 py-2">Karyawan</th>
                    <th class="px-4 py-2">Shift</th>
                    <th class="px-4 py-2">Masuk</th>
                    <th class="px-4 py-2">Istirahat</th>
                    <th class="px-4 py-2">Pulang</th>
                    <th class="px-4 py-2 text-center">Telat</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($rekap as $row)
                    <tr class="border-b border-slate-100 hover:bg-slate-50">
                        <td class="px-4 py-2">
                            <div class="font-semibold text-slate-800">
                                {{ $row->karyawan->nama ?? 'ID: '.$row->id_finger }}
                            </div>
                            <div class="text-xs text-slate-500">
                                {{ $row->karyawan->departemen->nama ?? '-' }}
                            </div>
                        </td>
                        <td class="px-4 py-2 text-xs text-slate-700">
                            {{ $row->shift ? 'Shift '.$row->shift : '-' }}
                        </td>
                        <td class="px-4 py-2 text-xs text-slate-700">
                            {{ $row->jam_masuk ? $row->jam_masuk->format('H:i') : '-' }}
                        </td>
                        <td class="px-4 py-2 text-xs text-slate-700">
                            @if($row->jam_istirahat_keluar || $row->jam_istirahat_masuk)
                                {{ $row->jam_istirahat_keluar ? $row->jam_istirahat_keluar->format('H:i') : ' - ' }}
                                &mdash;
                                {{ $row->jam_istirahat_masuk ? $row->jam_istirahat_masuk->format('H:i') : ' - ' }}
                            @else
                                -
                            @endif
                        </td>
                        <td class="px-4 py-2 text-xs text-slate-700">
                            {{ $row->jam_pulang ? $row->jam_pulang->format('H:i') : '-' }}
                        </td>
                        <td class="px-4 py-2 text-xs text-center">
                            @if ($row->telat_menit > 0)
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-orange-100 text-orange-700">
                                    {{ $row->telat_menit }} mnt
                                </span>
                            @else
                                <span class="text-slate-400">-</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-6 text-center text-sm text-slate-500">
                            Belum ada rekap absen untuk tanggal ini. Klik "Proses Ulang" untuk mengolah dari data absen mentah.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
