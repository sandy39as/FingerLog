@extends('layouts.app')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Absen Mentah</h1>
            <p class="text-sm text-slate-500 mt-1">
                Data log mentah yang diambil langsung dari mesin fingerprint.
            </p>
        </div>

        <a href="{{ route('absen-mentah.import') }}"
           class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700">
            + Import Excel
        </a>
    </div>

    @if (session('success'))
        <div class="mb-4 px-4 py-2 text-sm text-emerald-800 bg-emerald-50 border border-emerald-200 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    {{-- Filter tanggal --}}
    <form method="GET" class="mb-4">
        <div class="flex gap-2 items-center text-sm">
            <label for="tanggal" class="text-slate-600">Tanggal</label>
            <input type="date" id="tanggal" name="tanggal"
                   value="{{ $tanggal }}"
                   class="border border-slate-300 rounded-lg px-3 py-1.5 text-sm">
            <button class="px-3 py-1.5 bg-slate-700 text-white rounded-lg">
                Filter
            </button>
        </div>
    </form>

    <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-x-auto">
        <table class="min-w-full text-sm text-left">
            <thead class="bg-slate-50 border-b border-slate-200 text-xs uppercase text-slate-500">
                <tr>
                    <th class="px-4 py-2">Waktu</th>
                    <th class="px-4 py-2">ID Finger</th>
                    <th class="px-4 py-2">Jenis</th>
                    <th class="px-4 py-2">Sumber</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($logs as $log)
                    <tr class="border-b border-slate-100 hover:bg-slate-50">
                        <td class="px-4 py-2 text-xs text-slate-700">
                            {{ $log->tanggal_waktu->format('d/m/Y H:i:s') }}
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
                        <td class="px-4 py-2 text-xs text-slate-500">
                            {{ $log->sumber_file ?? '-' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-6 text-center text-sm text-slate-500">
                            Belum ada data absen mentah. Silakan import file Excel dari mesin fingerprint.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="px-4 py-3 border-t border-slate-200 text-xs text-slate-500">
            {{ $logs->links() }}
        </div>
    </div>
@endsection
