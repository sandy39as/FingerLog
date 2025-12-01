<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use Illuminate\Http\Request;
use App\Imports\KaryawanImport;
use Maatwebsite\Excel\Facades\Excel;


class KaryawanController extends Controller
{
    public function index()
    {
        $karyawans = Karyawan::orderBy('nama')->paginate(20);

        return view('karyawan.index', compact('karyawans'));
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv',
        ]);

        Excel::import(new KaryawanImport, $request->file('file'));

        return back()->with('success', 'Data karyawan asli berhasil diimport / diperbarui.');
    }
}
