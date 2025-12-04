<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    public function index()
    {
        $today = now()->toDateString();

        // --- 1. Statistik dasar (aman walau tabel absen belum ada) ---
        $totalKaryawan    = Karyawan::count();
        $hadirHariIni     = 0;
        $terlambatHariIni = 0;
        $belumPulang      = 0;

        // data untuk grafik & tabel
        $chartLabels = [];
        $chartData   = [];
        $recentLogs  = [];

        // Kalau tabel absen_harian sudah ada, baru ambil datanya
        if (Schema::hasTable('absen_harian')) {
            // Hadir hari ini = ada jam_masuk
            $hadirHariIni = DB::table('absen_harian')
                ->whereDate('tanggal', $today)
                ->whereNotNull('jam_masuk')
                ->count();

            // Terlambat hari ini = telat_menit > 0
            $terlambatHariIni = DB::table('absen_harian')
                ->whereDate('tanggal', $today)
                ->where('telat_menit', '>', 0)
                ->count();

            // Belum pulang = sudah masuk tapi jam_pulang null
            $belumPulang = DB::table('absen_harian')
                ->whereDate('tanggal', $today)
                ->whereNotNull('jam_masuk')
                ->whereNull('jam_pulang')
                ->count();

            // Grafik 7 hari terakhir (jumlah hadir per hari)
            $rekap7Hari = DB::table('absen_harian')
                ->select('tanggal', DB::raw('count(*) as total_hadir'))
                ->whereNotNull('jam_masuk')
                ->whereDate('tanggal', '>=', now()->subDays(6)->toDateString())
                ->groupBy('tanggal')
                ->orderBy('tanggal', 'asc')
                ->get();

            $chartLabels = $rekap7Hari->pluck('tanggal')->map(function ($tgl) {
                return \Carbon\Carbon::parse($tgl)->translatedFormat('d M');
            })->toArray();

            $chartData = $rekap7Hari->pluck('total_hadir')->toArray();
        }

        // Aktivitas terbaru: kalau sudah ada tabel absen_mentah, pakai itu.
        if (Schema::hasTable('absen_mentah')) {
            $recentLogs = DB::table('absen_mentah')
                ->orderBy('tanggal_waktu', 'desc')
                ->limit(10)
                ->get();
        }

        return view('dashboard', [
            'today'             => $today,
            'totalKaryawan'     => $totalKaryawan,
            'hadirHariIni'      => $hadirHariIni,
            'terlambatHariIni'  => $terlambatHariIni,
            'belumPulang'       => $belumPulang,
            'chartLabels'       => $chartLabels,
            'chartData'         => $chartData,
            'recentLogs'        => $recentLogs,
        ]);
    }
}
