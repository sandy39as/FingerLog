@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto">
        <h1 class="text-2xl font-bold text-slate-800 mb-4">Tambah Karyawan</h1>

        <div class="bg-white border border-slate-200 rounded-xl shadow-sm p-6">
            <form action="{{ route('karyawan.store') }}" method="POST">
                @include('karyawan._form', ['karyawan' => null])
            </form>
        </div>
    </div>


@endsection
