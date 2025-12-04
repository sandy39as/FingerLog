@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto">
    <h1 class="text-2xl font-bold text-slate-800 mb-4">
        Import Absen Mentah dari Excel
    </h1>

    <div class="bg-white border border-slate-200 rounded-xl p-6 shadow-sm">
        @if ($errors->any())
            <div class="mb-4 p-3 text-sm text-red-700 bg-red-50 border border-red-200 rounded-lg">
                {{ $errors->first('file') }}
            </div>
        @endif

        <form action="{{ route('absen-mentah.import.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <label class="block text-sm font-medium text-slate-700 mb-2">
                File Excel (.xlsx)
            </label>
            <input type="file" name="file"
                   class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm">

            <p class="text-xs text-slate-500 mt-2">
                Format header: <code>id_finger, tanggal_waktu, jenis_absen</code>
            </p>

            <div class="flex justify-end mt-5">
                <a href="{{ route('absen-mentah.index') }}"
                   class="px-4 py-2 text-sm border border-slate-300 rounded-lg text-slate-700 hover:bg-slate-100">
                    Batal
                </a>
                <button type="submit"
                        class="ml-2 px-4 py-2 text-sm bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Import Sekarang
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
