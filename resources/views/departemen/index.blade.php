@extends('layouts.app')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Departemen</h1>
            <p class="text-sm text-slate-500 mt-1">
                Master data departemen perusahaan.
            </p>
        </div>

        <a href="{{ route('departemen.create') }}"
           class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700">
            + Tambah Departemen
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
                    <th class="px-4 py-2">Kode</th>
                    <th class="px-4 py-2">Nama Departemen</th>
                    <th class="px-4 py-2 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($departemen as $row)
                    <tr class="border-b border-slate-100 hover:bg-slate-50">
                        <td class="px-4 py-2 text-xs font-mono text-slate-700">
                            {{ $row->kode ?? '-' }}
                        </td>
                        <td class="px-4 py-2 text-sm font-semibold text-slate-800">
                            {{ $row->nama }}
                        </td>
                        <td class="px-4 py-2 text-xs text-right space-x-2">
                            <a href="{{ route('departemen.edit', $row) }}"
                            class="inline-flex items-center px-2 py-1 rounded-md border border-slate-300 text-slate-700 hover:bg-slate-100">
                                Edit
                            </a>

                            <form action="{{ route('departemen.destroy', $row) }}"
                                method="POST"
                                class="inline-block"
                                onsubmit="return confirm('Yakin ingin menghapus departemen ini?')">
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
                        <td colspan="3" class="px-4 py-6 text-center text-sm text-slate-500">
                            Belum ada data departemen.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
