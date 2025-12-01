@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto py-6">
    <h2 class="text-2xl font-bold mb-4">Rekap Absensi</h2>

    @if (session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
            {{ session('success') }}
        </div>
    @endif

    {{-- FORM PROSES REKAP --}}
    <form action="{{ route('absensi.proses') }}" method="post" class="mb-4">
        @csrf
        <label class="font-semibold">Proses Tanggal</label>
        <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" class="border p-1 rounded">
        <button class="px-4 py-1 bg-emerald-600 text-white rounded text-sm">
            Proses Rekap
        </button>
    </form>

    {{-- FORM IMPORT EXCEL --}}
    <form action="{{ route('absensi.import') }}" method="post" enctype="multipart/form-data" class="mb-6">
        @csrf
        <label class="block mb-2 font-semibold">Import Excel Finger</label>
        <input type="file" name="file" class="mb-2">
        <button class="px-4 py-1 bg-blue-600 text-white rounded text-sm">Upload</button>
    </form>

    <div class="bg-white shadow rounded p-4">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-100 text-gray-700">
                    <th class="p-2">Nama</th>
                    <th class="p-2">Tanggal</th>
                    <th class="p-2">Shift</th>
                    <th class="p-2">Masuk</th>
                    <th class="p-2">Istirahat</th>
                    <th class="p-2">Masuk Lagi</th>
                    <th class="p-2">Pulang</th>
                    <th class="p-2">Telat</th>
                    <th class="p-2">Lembur</th>
                    <th class="p-2">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($rekap as $r)
                    <tr class="border-b">
                        <td class="p-2">{{ $r->karyawan->nama }}</td>
                        <td class="p-2">{{ $r->tanggal }}</td>
                        <td class="p-2">{{ $r->shift->nama_shift }}</td>

                        <td class="p-2">{{ $r->jam_masuk }}</td>
                        <td class="p-2">{{ $r->jam_istirahat_mulai }}</td>
                        <td class="p-2">{{ $r->jam_istirahat_selesai }}</td>
                        <td class="p-2">{{ $r->jam_pulang }}</td>

                        <td class="p-2 {{ $r->status_telat ? 'text-red-600 font-bold' : '' }}">
                            {{ $r->status_telat ? $r->menit_telat . ' menit' : '-' }}
                        </td>

                        <td class="p-2 {{ $r->status_lembur ? 'text-blue-600 font-bold' : '' }}">
                            {{ $r->status_lembur ? $r->menit_lembur . ' menit' : '-' }}
                        </td>

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
                            Belum ada data absensi.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

<form action="{{ route('absensi.export') }}" method="get" class="mb-4 flex items-center gap-2">
    <label class="font-semibold text-sm">Export Rekap Tanggal</label>
    <input type="date" name="tanggal" value="{{ request('tanggal', date('Y-m-d')) }}" class="border p-1 rounded text-sm">
    <button class="px-3 py-1 bg-indigo-600 text-white rounded text-sm">
        Export Excel
    </button>
</form>


        <div class="mt-4">
            {{ $rekap->links() }}
        </div>
    </div>
</div>
@endsection
