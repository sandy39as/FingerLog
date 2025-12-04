@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto">
    <h1 class="text-2xl font-bold text-slate-800 mb-4">
        Detail Karyawan
    </h1>

    <div class="bg-white border border-slate-200 shadow-sm rounded-xl p-6 space-y-3">
        
        <div>
            <p class="text-xs text-slate-500">Nama</p>
            <p class="text-sm font-semibold">{{ $karyawan->nama }}</p>
        </div>

        <div>
            <p class="text-xs text-slate-500">NIK</p>
            <p class="text-sm">{{ $karyawan->nik ?? '-' }}</p>
        </div>

        <div>
            <p class="text-xs text-slate-500">ID Finger</p>
            <p class="text-sm">{{ $karyawan->id_finger }}</p>
        </div>

        <div>
            <p class="text-xs text-slate-500">Departemen</p>
            <p class="text-sm">{{ $karyawan->departemen->nama ?? '-' }}</p>
        </div>

        <div>
            <p class="text-xs text-slate-500">Status</p>
            <p class="text-sm">{{ ucfirst($karyawan->status_karyawan) }}</p>
        </div>

    </div>
</div>
@endsection
