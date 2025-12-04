@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto">
        <h1 class="text-2xl font-bold text-slate-800 mb-4">Edit Karyawan</h1>

        <div class="bg-white border border-slate-200 rounded-xl shadow-sm p-6">
            <form action="{{ route('karyawan.update', $karyawan) }}" method="POST">
                @method('PUT')
                @include('karyawan._form', ['karyawan' => $karyawan])
            </form>
        </div>
    </div>

    <div>
    <label class="block text-sm font-medium text-slate-700 mb-1">
        Departemen
    </label>
    <select name="departemen_id"
            class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm">
        <option value="">-- Pilih Departemen --</option>
        @foreach ($departemen as $dept)
            <option value="{{ $dept->id }}"
                {{ old('departemen_id', $karyawan->departemen_id) == $dept->id ? 'selected' : '' }}>
                {{ $dept->nama }}
            </option>
        @endforeach
    </select>
    @error('departemen_id')
        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
    @enderror
</div>

@endsection
