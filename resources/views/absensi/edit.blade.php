@extends('layouts.app')

@section('content')

    <div class="max-w-xl mx-auto py-6">
        <h2 class="text-2xl font-bold mb-4">Edit Absensi</h2>

        <div class="mb-4 p-3 bg-gray-100 rounded">
            <p><strong>Nama:</strong> {{ $absen->karyawan->nama }}</p>
            <p><strong>Tanggal:</strong> {{ $absen->tanggal }}</p>
        </div>

        <form action="{{ route('absensi.update', $absen->id) }}" method="post" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-semibold mb-1">Shift</label>
                <select name="shift_id" class="border rounded p-1 w-full">
                    <option value="">Auto (deteksi dari jam masuk)</option>
                    @foreach ($shifts as $shift)
                        <option value="{{ $shift->id }}"
                            @selected($shift->id == $absen->shift_id)>
                            {{ $shift->nama_shift }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold mb-1">Jam Masuk (HH:MM)</label>
                    <input
                        type="time"
                        name="jam_masuk"
                        value="{{ $absen->jam_masuk ? \Carbon\Carbon::parse($absen->jam_masuk)->format('H:i') : '' }}"
                        class="border rounded p-1 w-full">
                </div>
                <div>
                    <label class="block text-sm font-semibold mb-1">Jam Pulang (HH:MM)</label>
                    <input
                        type="time"
                        name="jam_pulang"
                        value="{{ $absen->jam_pulang ? \Carbon\Carbon::parse($absen->jam_pulang)->format('H:i') : '' }}"
                        class="border rounded p-1 w-full">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold mb-1">Istirahat Mulai</label>
                    <input
                        type="time"
                        name="jam_istirahat_mulai"
                        value="{{ $absen->jam_istirahat_mulai ? \Carbon\Carbon::parse($absen->jam_istirahat_mulai)->format('H:i') : '' }}"
                        class="border rounded p-1 w-full">
                </div>
                <div>
                    <label class="block text-sm font-semibold mb-1">Istirahat Selesai</label>
                    <input
                        type="time"
                        name="jam_istirahat_selesai"
                        value="{{ $absen->jam_istirahat_selesai ? \Carbon\Carbon::parse($absen->jam_istirahat_selesai)->format('H:i') : '' }}"
                        class="border rounded p-1 w-full">
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold mb-1">Keterangan (opsional)</label>
                <textarea name="keterangan" rows="3" class="border rounded p-1 w-full">{{ $absen->keterangan }}</textarea>
            </div>

            <div class="flex gap-3 mt-4">
                <button class="px-4 py-2 bg-emerald-600 text-white rounded">
                    Simpan Perubahan
                </button>
                <a href="{{ route('absensi.index') }}" class="px-4 py-2 bg-gray-300 text-gray-800 rounded">
                    Batal
                </a>
            </div>
        </form>
    </div>

@endsection
