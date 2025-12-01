<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use Illuminate\Http\Request;
use App\Imports\KaryawanImport;
use Maatwebsite\Excel\Facades\Excel;


class KaryawanController extends Controller
{
    public function index(Request $request)
    {
        $query = Karyawan::query();

        // Search nama
        if ($request->filled('search')) {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }

        // Filter bagian
        if ($request->filled('bagian')) {
            $query->where('bagian', $request->bagian);
        }

        // Ambil data karyawan
        $karyawans = $query->orderBy('nama')->paginate(15);

        // Ambil list bagian unik untuk dropdown
        $bagianOptions = Karyawan::whereNotNull('bagian')
            ->where('bagian', '<>', '')
            ->select('bagian')
            ->distinct()
            ->orderBy('bagian')
            ->pluck('bagian');

        return view('karyawan.index', compact('karyawans', 'bagianOptions'));
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
