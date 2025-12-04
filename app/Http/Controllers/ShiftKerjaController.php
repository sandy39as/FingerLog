<?php

namespace App\Http\Controllers;

use App\Models\ShiftKerja;
use Illuminate\Http\Request;

class ShiftKerjaController extends Controller
{
    public function index()
    {
        $shifts = ShiftKerja::orderBy('id')->get();

        return view('shift.index', compact('shifts'));
    }

    public function create()
    {
        return view('shift.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_shift'             => 'required|string|max:100',
            'jam_masuk'              => 'required|date_format:H:i',
            'jam_keluar_istirahat'   => 'nullable|date_format:H:i',
            'jam_masuk_istirahat'    => 'nullable|date_format:H:i',
            'jam_pulang'             => 'required|date_format:H:i',
            'toleransi_telat_menit'  => 'nullable|integer|min:0',
        ]);

        ShiftKerja::create([
            'nama_shift'            => $request->nama_shift,
            'jam_masuk'             => $request->jam_masuk,
            'jam_keluar_istirahat'  => $request->jam_keluar_istirahat,
            'jam_masuk_istirahat'   => $request->jam_masuk_istirahat,
            'jam_pulang'            => $request->jam_pulang,
            'toleransi_telat_menit' => $request->toleransi_telat_menit ?? 0,
        ]);

        return redirect()->route('shift.index')
            ->with('success', 'Shift kerja berhasil ditambahkan.');
    }

    public function edit(ShiftKerja $shift)
    {
        return view('shift.edit', compact('shift'));
    }

    public function update(Request $request, ShiftKerja $shift)
    {
        $request->validate([
            'nama_shift'             => 'required|string|max:100',
            'jam_masuk'              => 'required|date_format:H:i',
            'jam_keluar_istirahat'   => 'nullable|date_format:H:i',
            'jam_masuk_istirahat'    => 'nullable|date_format:H:i',
            'jam_pulang'             => 'required|date_format:H:i',
            'toleransi_telat_menit'  => 'nullable|integer|min:0',
        ]);

        $shift->update([
            'nama_shift'            => $request->nama_shift,
            'jam_masuk'             => $request->jam_masuk,
            'jam_keluar_istirahat'  => $request->jam_keluar_istirahat,
            'jam_masuk_istirahat'   => $request->jam_masuk_istirahat,
            'jam_pulang'            => $request->jam_pulang,
            'toleransi_telat_menit' => $request->toleransi_telat_menit ?? 0,
        ]);

        return redirect()->route('shift.index')
            ->with('success', 'Shift kerja berhasil diperbarui.');
    }

    public function destroy(ShiftKerja $shift)
    {
        $shift->delete();

        return redirect()->route('shift.index')
            ->with('success', 'Shift kerja berhasil dihapus.');
    }
}