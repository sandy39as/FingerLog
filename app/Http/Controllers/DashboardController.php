<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Absen;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
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

        $lemburHariIni = Absen::whereDate('tanggal', $today)
            ->where('status_lembur', true)
            ->count();

        $totalMenitLemburHariIni = Absen::whereDate('tanggal', $today)
            ->sum('menit_lembur');

        $belumPulang = Absen::whereDate('tanggal', $today)
            ->whereNull('jam_pulang')
            ->count();

        // Rekap detail hari ini
        $rekap = Absen::with(['karyawan', 'shift'])
            ->whereDate('tanggal', $today)
            ->orderBy('jam_masuk')
            ->paginate(10);

        return view('dashboard', compact(
            'totalKaryawan',
            'hadirHariIni',
            'terlambatHariIni',
            'totalMenitTelatHariIni',
            'lemburHariIni',
            'totalMenitLemburHariIni',
            'belumPulang',
            'rekap',
            'today'
        ));
    }
}
