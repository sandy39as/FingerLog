{{-- resources/views/dashboard.blade.php --}}
@extends('layouts.app')

@section('content')

    <div class="max-w-5xl mx-auto py-6">
        <h1 class="text-2xl font-bold mb-4">Data Karyawan</h1>


        <form action="{{ route('karyawan.import') }}" method="post" enctype="multipart/form-data" class="mb-4 flex items-center gap-3">
            @csrf
            <div>
                <label class="block text-sm font-semibold mb-1">Import Excel Karyawan Asli</label>
                <input type="file" name="file" class="block text-sm">
            </div>
            <button class="mt-5 px-4 py-2 bg-blue-600 text-white text-sm rounded">
                Upload & Import
            </button>
        </form>

        <table class="w-full text-sm bg-white border border-slate-200 rounded-lg overflow-hidden">
            <thead class="bg-slate-50 text-slate-600 text-xs uppercase">
                <tr>
                    <th class="px-4 py-2 text-left">Nama</th>
                    <th class="px-4 py-2 text-left">Bagian</th>
                </tr>
            </thead>
            <tbody>
                @forelse($karyawans as $karyawan)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $karyawan->nama }}</td>
                        <td class="px-4 py-2">{{ $karyawan->bagian ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-4 py-4 text-center text-slate-500">
                            Belum ada data karyawan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $karyawans->links() }}
        </div>
    </div>
@endsection
