<?php

namespace App\Http\Controllers;

use App\Imports\AbsenMentahImport;
use App\Models\AbsenMentah;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class AbsenMentahController extends Controller
{
    public function index(Request $request)
    {
        $tanggal = $request->get('tanggal');

        $query = AbsenMentah::query()->orderByDesc('tanggal_waktu');

        if ($tanggal) {
            $query->whereDate('tanggal_waktu', $tanggal);
        }

        $logs = $query->paginate(20);

        return view('absen_mentah.index', [
            'logs'    => $logs,
            'tanggal' => $tanggal,
        ]);
    }

    public function importForm()
    {
        return view('absen_mentah.import');
    }

    public function importStore(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        $file = $request->file('file');
        $namaFile = $file->getClientOriginalName();

        Excel::import(new AbsenMentahImport($namaFile), $file);

        return redirect()->route('absen-mentah.index')
            ->with('success', 'Import data absen mentah berhasil.');
    }
}
