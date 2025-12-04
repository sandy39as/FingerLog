@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto">
    <h1 class="text-2xl font-bold text-slate-800 mb-4">
        Tambah Departemen
    </h1>

    <div class="bg-white border border-slate-200 rounded-xl p-6 shadow-sm">
        @if ($errors->any())
            <div class="mb-4 p-3 text-sm text-red-700 bg-red-50 border border-red-200 rounded-lg">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('departemen.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">
                    Nama Departemen
                </label>
                <input type="text" name="nama" value="{{ old('nama') }}"
                       class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">
                    Kode (opsional)
                </label>
                <input type="text" name="kode" value="{{ old('kode') }}"
                       class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm"
                       placeholder="Misal: PRD, QC, PKG">
            </div>

            <div class="flex justify-end gap-2 pt-2">
                <a href="{{ route('departemen.index') }}"
                   class="px-4 py-2 text-sm border border-slate-300 rounded-lg text-slate-700 hover:bg-slate-100">
                    Batal
                </a>
                <button type="submit"
                        class="px-4 py-2 text-sm bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
