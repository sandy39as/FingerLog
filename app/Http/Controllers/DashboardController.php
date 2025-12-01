<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Absen;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // ====== Bagian ABSENSI (statistik hari ini) ======
        $today = Carbon::today()->toDateString();

        $totalKaryawan = Karyawan::count();

        $hadirHariIni = Absen::whereDate('tanggal', $today)
            ->whereNotNull('jam_masuk')
            ->count();

        $terlambatHariIni = Absen::whereDate('tanggal', $today)
            ->where('status_telat', true)
            ->where('menit_telat', '>', 0)
            ->count();

        $totalMenitTelatHariIni = Absen::whereDate('tanggal', $today)
            ->sum('menit_telat');

        // kalau lembur sudah tidak dipakai di view, ini boleh dihapus
        $lemburHariIni = Absen::whereDate('tanggal', $today)
            ->where('status_lembur', true)
            ->count();

        $totalMenitLemburHariIni = Absen::whereDate('tanggal', $today)
            ->sum('menit_lembur');

        $belumPulang = Absen::whereDate('tanggal', $today)
            ->whereNull('jam_pulang')
            ->count();

        // Rekap detail hari ini (kalau masih ada view yang pakai)
        $rekap = Absen::with(['karyawan', 'shift'])
            ->whereDate('tanggal', $today)
            ->orderBy('jam_masuk')
            ->paginate(10);

        // ====== Bagian KARYAWAN (search + filter) ======
        $query = Karyawan::query();

        // search nama
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('nama', 'like', "%{$search}%");
        }

        // filter bagian
        if ($request->filled('bagian')) {
            $query->where('bagian', $request->bagian);
        }

        // data karyawan paginasi
        $karyawans = $query
            ->orderBy('nama')
            ->paginate(15);

        // list bagian untuk dropdown (distinct)
        $bagianOptions = Karyawan::whereNotNull('bagian')
            ->where('bagian', '<>', '')
            ->select('bagian')
            ->distinct()
            ->orderBy('bagian')
            ->pluck('bagian');

        // lempar semua ke view 'dashboard'
        return view('dashboard', [
            'today'                  => $today,
            'totalKaryawan'          => $totalKaryawan,
            'hadirHariIni'           => $hadirHariIni,
            'terlambatHariIni'       => $terlambatHariIni,
            'totalMenitTelatHariIni' => $totalMenitTelatHariIni,
            'lemburHariIni'          => $lemburHariIni,
            'totalMenitLemburHariIni'=> $totalMenitLemburHariIni,
            'belumPulang'            => $belumPulang,
            'rekap'                  => $rekap,

            'karyawans'              => $karyawans,
            'bagianOptions'          => $bagianOptions,
        ]);
    }
}
