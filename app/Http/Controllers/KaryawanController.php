<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\KaryawanImport;
use App\Models\Departemen;

class KaryawanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');

        $karyawan = Karyawan::with('departemen')
            ->when($search, function ($query) use ($search) {
                $query->where('nama', 'like', "%{$search}%")
                      ->orWhere('nik', 'like', "%{$search}%")
                      ->orWhere('id_finger', 'like', "%{$search}%");
            })
            ->orderBy('nama')
            ->paginate(10);

        return view('karyawan.index', [
            'karyawan' => $karyawan,
            'search'   => $search,
        ]);
    }

    public function create()
{
    $departemen = Departemen::orderBy('nama')->get();

    return view('karyawan.create', compact('departemen'));
}

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'          => 'required|string|max:100',
            'nik'           => 'nullable|string|max:50',
            'id_finger'     => 'required|string|max:50',
            'jabatan'       => 'nullable|string|max:100',
            'status_karyawan' => 'required|in:aktif,nonaktif',
            'departemen_id' => 'required|exists:departemen,id',
        ]);

        Karyawan::create([
        'nama'           => $request->nama,
        'nik'            => $request->nik,
        'id_finger'      => $request->id_finger,
        'jabatan'        => $request->jabatan,
        'status_karyawan'=> $request->status_karyawan,
        'departemen_id'  => $request->departemen_id,
]);


        return redirect()->route('karyawan.index')
            ->with('success', 'Karyawan berhasil ditambahkan.');
    }

    public function edit(Karyawan $karyawan)
{
    $departemen = Departemen::orderBy('nama')->get();

    return view('karyawan.edit', compact('karyawan', 'departemen'));
}


    public function update(Request $request, Karyawan $karyawan)
    {
        $validated = $request->validate([
            'nama'          => 'required|string|max:100',
            'nik'           => 'nullable|string|max:50',
            'id_finger'     => 'required|string|max:50',
            'jabatan'       => 'nullable|string|max:100',
            'status_karyawan' => 'required|in:aktif,nonaktif',
            'departemen_id' => 'required|exists:departemen,id',
        ]);

        $karyawan->update([
        'nama'           => $request->nama,
        'nik'            => $request->nik,
        'id_finger'      => $request->id_finger,
        'jabatan'        => $request->jabatan,
        'status_karyawan'=> $request->status_karyawan,
        'departemen_id'  => $request->departemen_id,
        ]);

        return redirect()->route('karyawan.index')
            ->with('success', 'Data karyawan berhasil diperbarui.');
    }

    public function destroy(Karyawan $karyawan)
    {
        $karyawan->delete();

        return redirect()->route('karyawan.index')
            ->with('success', 'Karyawan berhasil dihapus.');
    }

    public function importForm()
{
    return view('karyawan.import');
}

public function importStore(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:xlsx,xls'
    ]);

    Excel::import(new KaryawanImport, $request->file('file'));

    return redirect()->route('karyawan.index')
        ->with('success', 'Import data karyawan berhasil.');
}

public function show(Karyawan $karyawan)
{
    return view('karyawan.show', compact('karyawan'));
}



}
