<?php

namespace App\Http\Controllers;

use App\Imports\AbsenMentahImport;
use App\Services\ProsesAbsensiService;
use App\Models\Absen;
use App\Models\AbsenMentah;
use App\Models\Karyawan;
use App\Models\Shift;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AbsenRekapExport;
use Carbon\Carbon;

class AbsensiController extends Controller
{
    public function index()
    {
        $rekap = Absen::with('karyawan', 'shift')
            ->orderBy('tanggal', 'desc')
            ->paginate(20);

        return view('absensi.index', compact('rekap'));
    }

    // Upload Excel
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv',
        ]);

        Excel::import(new AbsenMentahImport, $request->file('file'));

        return back()->with('success', 'Data berhasil di-import!');
    }

    // Proses rekap 1 tanggal
    public function prosesTanggal(Request $request, ProsesAbsensiService $service)
    {
        $tanggal = $request->input('tanggal') ?? Carbon::today()->toDateString();

        $service->prosesTanggal($tanggal);

        return back()->with('success', "Absensi tanggal $tanggal berhasil diproses!");
    }

    public function edit(Absen $absen)
    {
        $shifts = Shift::orderBy('nama_shift')->get();

        return view('absensi.edit', [
            'absen'  => $absen->load('karyawan', 'shift'),
            'shifts' => $shifts,
        ]);
    }

    public function update(Request $request, Absen $absen)
    {
        $request->validate([
            'shift_id'              => 'nullable|exists:shifts,id', // <- nullable sekarang
            'jam_masuk'             => 'nullable|date_format:H:i',
            'jam_istirahat_mulai'   => 'nullable|date_format:H:i',
            'jam_istirahat_selesai' => 'nullable|date_format:H:i',
            'jam_pulang'            => 'nullable|date_format:H:i',
        ]);

        $tanggal = $absen->tanggal;

        // Konversi jam input -> Carbon (kalau ada)
        $jamMasuk = $request->jam_masuk
            ? Carbon::parse("$tanggal {$request->jam_masuk}:00")
            : null;

        $jamPulang = $request->jam_pulang
            ? Carbon::parse("$tanggal {$request->jam_pulang}:00")
            : null;

        // ==== AUTO DETECT SHIFT JIKA shift_id KOSONG ====
        if (!$request->shift_id) {
            // tentukan tipe hari
            $hari = Carbon::parse($tanggal);
            $hariTipe = $hari->isSaturday() ? 'sabtu' : 'weekday';

            $shift = null;

            if ($jamMasuk) {
                $timeStr = $jamMasuk->format('H:i:s');

                $shift = Shift::where('hari_tipe', $hariTipe)
                    ->where('range_masuk_mulai', '<=', $timeStr)
                    ->where('range_masuk_selesai', '>=', $timeStr)
                    ->orderBy('jam_masuk_normal')
                    ->first();
            }

            // fallback: kalau tetap nggak ketemu, pakai shift lama saja
            if (!$shift) {
                $shift = $absen->shift ?: Shift::first();
            }
        } else {
            $shift = Shift::findOrFail($request->shift_id);
        }

        // ==== NORMAL SHIFT LOGIC (telat, lembur, total menit) ====

        $jamMasukNormal  = Carbon::parse("$tanggal {$shift->jam_masuk_normal}");
        $jamPulangNormal = Carbon::parse("$tanggal {$shift->jam_pulang_normal}");

        $shiftMalam = $shift->jam_pulang_normal < $shift->jam_masuk_normal;

        if ($shiftMalam) {
            $jamPulangNormal->addDay();
            if ($jamPulang && $jamPulang->lt($jamMasuk ?? $jamMasukNormal)) {
                $jamPulang->addDay();
            }
        }

        // TELAT
        $statusTelat = false;
        $menitTelat  = 0;

        if ($jamMasuk && $jamMasuk->gt($jamMasukNormal)) {
            $statusTelat = true;
            $menitTelat  = $jamMasukNormal->diffInMinutes($jamMasuk);
        }

        // LEMBUR
        $statusLembur = false;
        $menitLembur  = 0;

        if ($jamPulang && $jamPulang->gt($jamPulangNormal)) {
            $selisih = $jamPulangNormal->diffInMinutes($jamPulang);
            if ($selisih >= $shift->minimal_lembur_menit) {
                $statusLembur = true;
                $menitLembur  = $selisih;
            }
        }

        // TOTAL MENIT KERJA
        $totalMenitKerja = null;
        if ($jamMasuk && $jamPulang) {
            $total = $jamMasuk->diffInMinutes($jamPulang);

            if ($request->jam_istirahat_mulai && $request->jam_istirahat_selesai) {
                $istMulai   = Carbon::parse("$tanggal {$request->jam_istirahat_mulai}:00");
                $istSelesai = Carbon::parse("$tanggal {$request->jam_istirahat_selesai}:00");

                if ($shiftMalam && $istSelesai->lt($istMulai)) {
                    $istSelesai->addDay();
                }

                $total -= $istMulai->diffInMinutes($istSelesai);
            }

            $totalMenitKerja = max($total, 0);
        }

        // SIMPAN
        $absen->shift_id              = $shift->id;
        $absen->jam_masuk             = $request->jam_masuk;
        $absen->jam_istirahat_mulai   = $request->jam_istirahat_mulai;
        $absen->jam_istirahat_selesai = $request->jam_istirahat_selesai;
        $absen->jam_pulang            = $request->jam_pulang;
        $absen->status_telat          = $statusTelat;
        $absen->menit_telat           = $menitTelat;
        $absen->status_lembur         = $statusLembur;
        $absen->menit_lembur          = $menitLembur;
        $absen->total_menit_kerja     = $totalMenitKerja;
        $absen->keterangan            = $request->keterangan;

        $absen->save();

        return redirect()
            ->route('absensi.index')
            ->with('success', 'Data absensi berhasil diperbarui.');
    }

    public function export(Request $request)
    {
        $tanggal = $request->input('tanggal') ?? Carbon::today()->toDateString();

        $filename = "rekap_absensi_{$tanggal}.xlsx";

        return Excel::download(new AbsenRekapExport($tanggal), $filename);
    }

    public function logMentah(Request $request)
    {
        $karyawans = Karyawan::orderBy('nama')->get();

        $karyawanId = $request->query('karyawan_id');
        $tanggal    = $request->query('tanggal');

        $logs   = collect();
        $absen  = null;
        $usedBy = [];

        if ($karyawanId && $tanggal) {
            $logs = AbsenMentah::where('karyawan_id', $karyawanId)
                ->whereDate('tanggal', $tanggal)
                ->orderBy('waktu_finger')
                ->get();

            $absen = Absen::where('karyawan_id', $karyawanId)
                ->whereDate('tanggal', $tanggal)
                ->first();

            if ($absen) {
                if ($absen->jam_masuk) {
                    $usedBy[Carbon::parse($absen->jam_masuk)->format('H:i:s')] = 'Masuk';
                }
                if ($absen->jam_istirahat_mulai) {
                    $usedBy[Carbon::parse($absen->jam_istirahat_mulai)->format('H:i:s')] = 'Istirahat Mulai';
                }
                if ($absen->jam_istirahat_selesai) {
                    $usedBy[Carbon::parse($absen->jam_istirahat_selesai)->format('H:i:s')] = 'Istirahat Selesai';
                }
                if ($absen->jam_pulang) {
                    $usedBy[Carbon::parse($absen->jam_pulang)->format('H:i:s')] = 'Pulang';
                }
            }
        }

        return view('absensi.log_mentah', [
            'karyawans'        => $karyawans,
            'logs'             => $logs,
            'usedBy'           => $usedBy,
            'selectedId'       => $karyawanId,
            'selectedTanggal'  => $tanggal,
            'absen'            => $absen,
        ]);
    }

    public function dashboard(Request $request)
    {
        $today = $request->input('tanggal', date('Y-m-d'));

        $rekap = Absen::with(['karyawan', 'shift'])
            ->whereDate('tanggal', $today)  
            ->orderBy('jam_masuk', 'asc')
            ->paginate(15);

        $totalKaryawan = Karyawan::count();

        $hadirHariIni = Absen::whereDate('tanggal', $today)->count();

        $terlambatHariIni = Absen::whereDate('tanggal', $today)
            ->where('status_telat', 1)
            ->count();

        $totalMenitTelatHariIni = Absen::whereDate('tanggal', $today)
            ->sum('menit_telat');

        $belumPulang = Absen::whereDate('tanggal', $today)
            ->whereNull('jam_pulang')
            ->count();

        return view('dashboard', compact(
            'today',
            'rekap',
            'totalKaryawan',
            'hadirHariIni',
            'terlambatHariIni',
            'totalMenitTelatHariIni',
            'belumPulang'
        ));
    }

}
