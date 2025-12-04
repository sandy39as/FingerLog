@extends('layouts.app')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Data Karyawan</h1>
            <p class="text-sm text-slate-500 mt-1">
                Master data karyawan yang terdaftar di sistem presensi.
            </p>
        </div>

        <div class="flex items-center gap-3">

        <a href="{{ route('karyawan.create') }}"
            class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition">
            + Tambah Karyawan
        </a>

        <a href="{{ route('karyawan.import') }}"
            class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition">
            Import Excel
        </a>

    </div>

    </div>

    {{-- Alert sukses --}}
    @if (session('success'))
        <div class="mb-4 px-4 py-2 text-sm text-emerald-800 bg-emerald-50 border border-emerald-200 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    {{-- Search --}}
    <form method="GET" class="mb-4">
        <div class="flex gap-2 max-w-md">
            <input type="text"
                   name="search"
                   value="{{ $search }}"
                   class="flex-1 border border-slate-300 rounded-lg px-3 py-2 text-sm"
                   placeholder="Cari nama, NIK, atau ID Finger...">
            <button class="px-3 py-2 text-sm bg-slate-700 text-white rounded-lg">
                Cari
            </button>
        </div>
    </form>

    {{-- Tabel --}}
    <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-x-auto">
        <table class="min-w-full text-sm text-left">
            <thead class="bg-slate-50 border-b border-slate-200 text-xs uppercase text-slate-500">
                <tr>
                    <th class="px-4 py-2">Nama</th>
                    <th class="px-4 py-2">NIK</th>
                    <th class="px-4 py-2">ID Finger</th>
                    <th class="px-4 py-2">Departemen</th>
                    <th class="px-4 py-2">Status</th>
                    <th class="px-4 py-2 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($karyawan as $row)
                    <tr class="border-b border-slate-100 hover:bg-slate-50">
                        <td class="px-4 py-2">
                            <div class="font-semibold text-slate-800">
                                {{ $row->nama }}
                            </div>
                            <div class="text-xs text-slate-500">
                                {{ $row->jabatan ?? '-' }}
                            </div>
                        </td>
                        <td class="px-4 py-2 text-xs text-slate-700">
                            {{ $row->nik ?? '-' }}
                        </td>
                        <td class="px-4 py-2 text-xs font-mono text-slate-800">
                            {{ $row->id_finger }}
                        </td>
                        <td class="px-4 py-2 text-xs text-slate-700">
                            {{ $row->departemen->nama ?? '-' }}
                        </td>
                        <td class="px-4 py-2 text-xs">
                            @if ($row->status_karyawan === 'aktif')
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-700">
                                    Aktif
                                </span>
                            @else
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-slate-100 text-slate-500">
                                    Nonaktif
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-2 text-xs text-right space-x-2">
                            <a href="{{ route('karyawan.edit', $row) }}"
                               class="inline-flex items-center px-2 py-1 rounded-md border border-slate-300 text-slate-700 hover:bg-slate-100">
                                Edit
                            </a>

                            <form action="{{ route('karyawan.destroy', $row) }}"
                                  method="POST"
                                  class="inline-block"
                                  onsubmit="return confirm('Yakin ingin menghapus karyawan ini?')">
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
                            Belum ada data karyawan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Pagination --}}
        <div class="px-4 py-3 border-t border-slate-200 text-xs text-slate-500">
            {{ $karyawan->links() }}
        </div>
    </div>
@endsection
