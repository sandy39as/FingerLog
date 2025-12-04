<?php

namespace App\Http\Controllers;

use App\Models\AbsenHarian;
use App\Models\AbsenMentah;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Exports\RekapAbsenHarianExport;
use Maatwebsite\Excel\Facades\Excel;


class AbsenHarianController extends Controller
{
    public function index(Request $request)
    {
        $tanggal = $request->get('tanggal', now()->toDateString());

        $rekap = AbsenHarian::with('karyawan.departemen')
            ->whereDate('tanggal', $tanggal)
            ->orderBy('jam_masuk')
            ->get();

        return view('absen_harian.index', [
            'tanggal' => $tanggal,
            'rekap'   => $rekap,
        ]);
    }

    public function proses(Request $request)
    {
        $tanggal = $request->input('tanggal', now()->toDateString());

        // hapus dulu rekap hari ini biar bisa re-proses
        AbsenHarian::whereDate('tanggal', $tanggal)->delete();

        // ambil log mentah hari itu
        $logs = AbsenMentah::whereDate('tanggal_waktu', $tanggal)
            ->orderBy('id_finger')
            ->orderBy('tanggal_waktu')
            ->get()
            ->groupBy('id_finger');

        foreach ($logs as $idFinger => $rows) {

            // urutkan
            $rows = $rows->values();

            $jamMasuk           = $rows->get(0)?->tanggal_waktu;
            $jamIstKeluar       = $rows->get(1)?->tanggal_waktu;
            $jamIstMasuk        = $rows->get(2)?->tanggal_waktu;
            $jamPulang          = $rows->get(3)?->tanggal_waktu;

            // tentukan shift berdasarkan jam masuk
            $shift = $this->tentukanShiftDariJamMasuk($jamMasuk);

            // hitung telat
            $telatMenit = 0;
            if ($jamMasuk && $shift) {
                $telatMenit = $this->hitungTelatMenit($tanggal, $jamMasuk, $shift);
            }

            // cari karyawan_id (opsional)
            $karyawan = Karyawan::where('id_finger', $idFinger)->first();

            AbsenHarian::create([
                'tanggal'             => $tanggal,
                'id_finger'           => $idFinger,
                'karyawan_id'         => $karyawan?->id,
                'shift'               => $shift,
                'jam_masuk'           => $jamMasuk,
                'jam_istirahat_keluar'=> $jamIstKeluar,
                'jam_istirahat_masuk' => $jamIstMasuk,
                'jam_pulang'          => $jamPulang,
                'telat_menit'         => $telatMenit,
            ]);
        }

        return redirect()->route('absen-harian.index', ['tanggal' => $tanggal])
            ->with('success', "Proses absen harian tanggal {$tanggal} selesai.");
    }

    private function tentukanShiftDariJamMasuk(?Carbon $jamMasuk): ?int
    {
        if (!$jamMasuk) {
            return null;
        }

        $waktu = $jamMasuk->format('H:i');

        // kasar: 05:00–11:59 -> Shift 1
        if ($waktu >= '05:00' && $waktu < '12:00') {
            return 1;
        }

        // 13:00–19:59 -> Shift 2
        if ($waktu >= '13:00' && $waktu < '20:00') {
            return 2;
        }

        // 21:00–23:59 atau 00:00–04:59 -> Shift 3
        if ($waktu >= '21:00' || $waktu < '05:00') {
            return 3;
        }

        return null;
    }

    private function hitungTelatMenit(string $tanggal, Carbon $jamMasuk, int $shift): int
    {
        // jam masuk standar per shift (umum dulu, nanti tinggal ubah)
        $jamMasukShift = match ($shift) {
            1 => '07:00',
            2 => '15:00',
            3 => '23:00',
            default => null,
        };

        if (!$jamMasukShift) {
            return 0;
        }

        // buat Carbon target jam masuk di tanggal itu
        $target = Carbon::parse($tanggal . ' ' . $jamMasukShift);

        // kalau shift malam dan jam masuk lewat tengah malam,
        // sebenarnya dia kerja dari malam sebelumnya -> ini bisa kamu adjust nanti
        if ($shift === 3 && $jamMasuk->format('H:i') < '05:00') {
            $target = Carbon::parse($jamMasuk->copy()->subDay()->format('Y-m-d') . ' ' . $jamMasukShift);
        }

        $diff = $target->diffInMinutes($jamMasuk, false);

        return $diff > 0 ? $diff : 0;
    }

    public function export(Request $request)
{
    $tanggal = $request->get('tanggal', now()->toDateString());

    $fileName = 'rekap_absen_harian_'.$tanggal.'.xlsx';

    return Excel::download(new RekapAbsenHarianExport($tanggal), $fileName);
}

}
