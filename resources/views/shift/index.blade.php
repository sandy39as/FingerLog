@extends('layouts.app')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Shift Kerja</h1>
            <p class="text-sm text-slate-500 mt-1">
                Pengaturan jam kerja dan batasan shift karyawan.
            </p>
        </div>

        <a href="{{ route('shift.create') }}"
           class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700">
            + Tambah Shift
        </a>
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
                    <th class="px-4 py-2">Nama Shift</th>
                    <th class="px-4 py-2">Jam Masuk</th>
                    <th class="px-4 py-2">Istirahat</th>
                    <th class="px-4 py-2">Jam Pulang</th>
                    <th class="px-4 py-2">Toleransi Telat</th>
                    <th class="px-4 py-2 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($shifts as $shift)
                    <tr class="border-b border-slate-100 hover:bg-slate-50">
                        <td class="px-4 py-2 text-sm font-semibold text-slate-800">
                            {{ $shift->nama_shift }}
                        </td>
                        <td class="px-4 py-2 text-xs text-slate-700">
                            {{ \Carbon\Carbon::parse($shift->jam_masuk)->format('H:i') }}
                        </td>
                        <td class="px-4 py-2 text-xs text-slate-700">
                            @if($shift->jam_keluar_istirahat || $shift->jam_masuk_istirahat)
                                {{ $shift->jam_keluar_istirahat ? \Carbon\Carbon::parse($shift->jam_keluar_istirahat)->format('H:i') : ' - ' }}
                                &mdash;
                                {{ $shift->jam_masuk_istirahat ? \Carbon\Carbon::parse($shift->jam_masuk_istirahat)->format('H:i') : ' - ' }}
                            @else
                                -
                            @endif
                        </td>
                        <td class="px-4 py-2 text-xs text-slate-700">
                            {{ \Carbon\Carbon::parse($shift->jam_pulang)->format('H:i') }}
                        </td>
                        <td class="px-4 py-2 text-xs text-slate-700">
                            {{ $shift->toleransi_telat_menit }} menit
                        </td>
                        <td class="px-4 py-2 text-xs text-right space-x-2">
                            <a href="{{ route('shift.edit', $shift) }}"
                               class="inline-flex items-center px-2 py-1 rounded-md border border-slate-300 text-slate-700 hover:bg-slate-100">
                                Edit
                            </a>

                            <form action="{{ route('shift.destroy', $shift) }}"
                                  method="POST"
                                  class="inline-block"
                                  onsubmit="return confirm('Yakin ingin menghapus shift ini?')">
                                @csrf
                                @method('DELETE')
                                <button
                                    class="inline-flex items-center px-2 py-1 rounded-md border border-red-300 text-red-600 hover:bg-red-50">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-6 text-center text-sm text-slate-500">
                            Belum ada data shift. Tambahkan shift kerja terlebih dahulu.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
