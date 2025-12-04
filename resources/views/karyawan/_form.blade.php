@csrf

<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
    <div>
        <label class="block text-xs font-medium text-slate-600 mb-1">Nama</label>
        <input type="text" name="nama"
               value="{{ old('nama', $karyawan->nama ?? '') }}"
               class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm"
               required>
        @error('nama') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-xs font-medium text-slate-600 mb-1">NIK</label>
        <input type="text" name="nik"
               value="{{ old('nik', $karyawan->nik ?? '') }}"
               class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm">
        @error('nik') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-xs font-medium text-slate-600 mb-1">ID Finger</label>
        <input type="text" name="id_finger"
               value="{{ old('id_finger', $karyawan->id_finger ?? '') }}"
               class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm"
               required>
        @error('id_finger') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-xs font-medium text-slate-600 mb-1">Jabatan</label>
        <input type="text" name="jabatan"
               value="{{ old('jabatan', $karyawan->jabatan ?? '') }}"
               class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm">
        @error('jabatan') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-xs font-medium text-slate-600 mb-1">Status</label>
        <select name="status_karyawan"
                class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm">
            <option value="aktif" {{ old('status_karyawan', $karyawan->status_karyawan ?? 'aktif') === 'aktif' ? 'selected' : '' }}>
                Aktif
            </option>
            <option value="nonaktif" {{ old('status_karyawan', $karyawan->status_karyawan ?? '') === 'nonaktif' ? 'selected' : '' }}>
                Nonaktif
            </option>
        </select>
        @error('status_karyawan') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
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
                {{ old('departemen_id') == $dept->id ? 'selected' : '' }}>
                {{ $dept->nama }}
            </option>
        @endforeach
    </select>
    @error('departemen_id')
        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
    @enderror
</div>

<div class="flex justify-end gap-2">
    <a href="{{ route('karyawan.index') }}"
       class="px-4 py-2 text-sm border border-slate-300 rounded-lg text-slate-700 hover:bg-slate-100">
        Batal
    </a>
    <button type="submit"
            class="px-4 py-2 text-sm bg-blue-600 text-white rounded-lg hover:bg-blue-700">
        Simpan
    </button>
</div>
