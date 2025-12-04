@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto">
    <h1 class="text-2xl font-bold text-slate-800 mb-4">
        Import Data Karyawan dari Excel
    </h1>

    <div class="bg-white border border-slate-200 rounded-xl p-6 shadow-sm">
        <form action="{{ route('karyawan.import.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <label class="block mb-2 text-sm text-slate-600">File Excel (*.xlsx)</label>
            <input type="file" name="file" required
                   class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm">

            @error('file')
                <p class="text-red-600 text-xs mt-2">{{ $message }}</p>
            @enderror

            <button class="mt-4 px-4 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700">
                Upload dan Import
            </button>
        </form>
    </div>
</div>
@endsection
