@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto py-8">

    {{-- Animasi sederhana --}}
    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(6px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .animate-fade-in-up {
            animation: fadeInUp 0.35s ease-out forwards;
        }
    </style>

    {{-- HEADER --}}
    <div class="flex items-center justify-between mb-4 animate-fade-in-up">
        <div>
            <h2 class="text-2xl font-extrabold text-slate-800">
                Edit Absensi
            </h2>
            <p class="text-sm text-slate-500">
                Sesuaikan jam masuk, pulang, istirahat, dan keterangan absensi karyawan.
            </p>
        </div>

        <a href="{{ route('absensi.index') }}"
           class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold
                  border border-slate-300 text-slate-600 bg-white hover:bg-slate-50 transition">
            ← Kembali
        </a>
    </div>

    {{-- INFO KARYAWAN --}}
    <div class="mb-5 p-4 bg-white border border-slate-200 rounded-2xl shadow-sm animate-fade-in-up" style="animation-delay:.05s">
        <p class="text-sm text-slate-700">
            <span class="font-semibold">Nama:</span>
            <span class="ml-1">{{ $absen->karyawan->nama }}</span>
        </p>
        <p class="text-sm text-slate-700 mt-1">
            <span class="font-semibold">Tanggal:</span>
            <span class="ml-1">{{ $absen->tanggal }}</span>
        </p>
    </div>

    {{-- ERROR VALIDASI --}}
    @if ($errors->any())
        <div class="mb-4 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800 animate-fade-in-up" style="animation-delay:.08s">
            <span class="font-semibold">Periksa kembali:</span>
            <ul class="list-disc list-inside mt-1 space-y-0.5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- FORM EDIT --}}
    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-5 animate-fade-in-up" style="animation-delay:.1s">
        <form action="{{ route('absensi.update', $absen->id) }}" method="post" class="space-y-5">
            @csrf
            @method('PUT')

            {{-- SHIFT --}}
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">
                    Shift
                </label>
                <select name="shift_id"
                        class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm
                               focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:border-emerald-400">
                    <option value="">Auto (deteksi dari jam masuk)</option>
                    @foreach ($shifts as $shift)
                        <option value="{{ $shift->id }}"
                            @selected(old('shift_id', $absen->shift_id) == $shift->id)>
                            {{ $shift->nama_shift }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- JAM MASUK / PULANG --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">
                        Jam Masuk (HH:MM)
                    </label>
                    <input
                        type="time"
                        name="jam_masuk"
                        value="{{ old('jam_masuk', $absen->jam_masuk ? \Carbon\Carbon::parse($absen->jam_masuk)->format('H:i') : '') }}"
                        class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm
                               focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:border-emerald-400">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">
                        Jam Pulang (HH:MM)
                    </label>
                    <input
                        type="time"
                        name="jam_pulang"
                        value="{{ old('jam_pulang', $absen->jam_pulang ? \Carbon\Carbon::parse($absen->jam_pulang)->format('H:i') : '') }}"
                        class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm
                               focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:border-emerald-400">
                </div>
            </div>

            {{-- ISTIRAHAT --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">
                        Istirahat Mulai
                    </label>
                    <input
                        type="time"
                        name="jam_istirahat_mulai"
                        value="{{ old('jam_istirahat_mulai', $absen->jam_istirahat_mulai ? \Carbon\Carbon::parse($absen->jam_istirahat_mulai)->format('H:i') : '') }}"
                        class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm
                               focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:border-emerald-400">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">
                        Istirahat Selesai
                    </label>
                    <input
                        type="time"
                        name="jam_istirahat_selesai"
                        value="{{ old('jam_istirahat_selesai', $absen->jam_istirahat_selesai ? \Carbon\Carbon::parse($absen->jam_istirahat_selesai)->format('H:i') : '') }}"
                        class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm
                               focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:border-emerald-400">
                </div>
            </div>

            {{-- KETERANGAN --}}
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">
                    Keterangan (opsional)
                </label>
                <textarea
                    name="keterangan"
                    rows="3"
                    class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm
                           focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:border-emerald-400">{{ old('keterangan', $absen->keterangan) }}</textarea>
            </div>

            {{-- BUTTONS --}}
            <div class="flex flex-wrap gap-3 pt-3">
                <button type="submit"
                        class="inline-flex items-center px-5 py-2.5 rounded-lg text-sm font-semibold
                               bg-emerald-600 text-white shadow-sm hover:bg-emerald-700 transition">
                    Simpan Perubahan
                </button>

                <a href="{{ route('absensi.index') }}"
                   class="inline-flex items-center px-5 py-2.5 rounded-lg text-sm font-semibold
                          border border-slate-300 text-slate-700 bg-white hover:bg-slate-50 transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
