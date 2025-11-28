<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\AbsenHarian;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        $totalKaryawan   = Karyawan::count();

        // Hadir hari ini: sesuaikan dengan status_harian yang kamu pakai
        $hadirHariIni    = AbsenHarian::whereDate('tanggal', $today)
                            ->where(function ($q) {
                                $q->where('status_harian', 'HADIR')
                                  ->orWhereNull('status_harian');
                            })
                            ->count();

        $terlambatHariIni = AbsenHarian::whereDate('tanggal', $today)
                            ->where('telat_menit', '>', 0)
                            ->count();

        $belumPulang      = AbsenHarian::whereDate('tanggal', $today)
                            ->whereNull('jam_pulang')
                            ->count();

        $rekapHariIni = AbsenHarian::with(['karyawan.departemen'])
                            ->whereDate('tanggal', $today)
                            ->orderBy('jam_masuk')
                            ->take(10)
                            ->get();

        return view('dashboard', compact(
            'totalKaryawan',
            'hadirHariIni',
            'terlambatHariIni',
            'belumPulang',
            'rekapHariIni',
            'today'
        ));
    }
}
