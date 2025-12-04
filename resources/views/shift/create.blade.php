@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto">
    <h1 class="text-2xl font-bold text-slate-800 mb-4">
        Tambah Shift Kerja
    </h1>

    <div class="bg-white border border-slate-200 rounded-xl p-6 shadow-sm">
        @if ($errors->any())
            <div class="mb-4 p-3 text-sm text-red-700 bg-red-50 border border-red-200 rounded-lg">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('shift.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">
                    Nama Shift
                </label>
                <input type="text" name="nama_shift" value="{{ old('nama_shift') }}"
                       class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm"
                       placeholder="Misal: Shift 1 / Pagi">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">
                        Jam Masuk
                    </label>
                    <input type="time" name="jam_masuk" value="{{ old('jam_masuk') }}"
                           class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">
                        Jam Pulang
                    </label>
                    <input type="time" name="jam_pulang" value="{{ old('jam_pulang') }}"
                           class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">
                        Keluar Istirahat
                    </label>
                    <input type="time" name="jam_keluar_istirahat" value="{{ old('jam_keluar_istirahat') }}"
                           class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">
                        Masuk Istirahat
                    </label>
                    <input type="time" name="jam_masuk_istirahat" value="{{ old('jam_masuk_istirahat') }}"
                           class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">
                    Toleransi Telat (menit)
                </label>
                <input type="number" name="toleransi_telat_menit" value="{{ old('toleransi_telat_menit', 0) }}"
                       class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm">
            </div>

            <div class="flex justify-end gap-2 pt-2">
                <a href="{{ route('shift.index') }}"
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
