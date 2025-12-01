<?php

namespace App\Services;

use App\Models\Absen;
use App\Models\AbsenMentah;
use App\Models\Shift;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class ProsesAbsensiService
{
    public function prosesTanggal($tanggal): void
    {
        $tanggal = Carbon::parse($tanggal)->toDateString();

        $logs = AbsenMentah::whereDate('tanggal', $tanggal)
            ->orderBy('karyawan_id')
            ->orderBy('waktu_finger')
            ->get()
            ->groupBy('karyawan_id');

        foreach ($logs as $karyawanId => $logKaryawan) {
            if ($logKaryawan->isEmpty()) {
                continue;
            }

            $firstLog = $logKaryawan->first();
            $shift    = $this->tentukanShiftDariWaktuFinger($firstLog->waktu_finger);

            if (!$shift) {
                continue;
            }

            // Ambil jam masuk/istirahat/pulang (kemungkinan berupa datetime)
            $rekapJam = $this->tentukanJamMasukIstirahatPulang($logKaryawan, $shift);

            $jamMasuk      = $rekapJam['jam_masuk'];
            $jamIstMulai   = $rekapJam['jam_istirahat_mulai'];
            $jamIstSelesai = $rekapJam['jam_istirahat_selesai'];
            $jamPulang     = $rekapJam['jam_pulang'];

            // Ubah ke string HH:MM untuk disimpan di tabel absens
            $jamMasukStr      = $jamMasuk      ? Carbon::parse($jamMasuk)->format('H:i') : null;
            $jamIstMulaiStr   = $jamIstMulai   ? Carbon::parse($jamIstMulai)->format('H:i') : null;
            $jamIstSelesaiStr = $jamIstSelesai ? Carbon::parse($jamIstSelesai)->format('H:i') : null;
            $jamPulangStr     = $jamPulang     ? Carbon::parse($jamPulang)->format('H:i') : null;

            // === PAKAI HELPER UNTUK HITUNG TELAT + LEMBUR + TOTAL KERJA ===
            [
                $statusTelat,
                $menitTelat,
                $statusLembur,
                $menitLembur,
                $totalMenitKerja
            ] = $this->hitungTelatLembur(
                $shift,
                $tanggal,
                $jamMasukStr,
                $jamIstMulaiStr,
                $jamIstSelesaiStr,
                $jamPulangStr
            );

            // Simpan / update rekap
            Absen::updateOrCreate(
                [
                    'karyawan_id' => $karyawanId,
                    'tanggal'     => $tanggal,
                ],
                [
                    'shift_id'              => $shift->id,
                    'jam_masuk'             => $jamMasukStr,
                    'jam_istirahat_mulai'   => $jamIstMulaiStr,
                    'jam_istirahat_selesai' => $jamIstSelesaiStr,
                    'jam_pulang'            => $jamPulangStr,
                    'status_telat'          => $statusTelat,
                    'menit_telat'           => $menitTelat,
                    'status_lembur'         => $statusLembur,
                    'menit_lembur'          => $menitLembur,
                    'total_menit_kerja'     => $totalMenitKerja,
                    'keterangan'            => null,
                ]
            );
        }
    }

    protected function hitungTelatLembur(
        Shift $shift,
        string $tanggal,
        ?string $jamMasuk,
        ?string $jamIstMulai,
        ?string $jamIstSelesai,
        ?string $jamPulang
    ): array {
        $jamMasukDt  = $jamMasuk  ? Carbon::parse("$tanggal {$jamMasuk}:00") : null;
        $jamPulangDt = $jamPulang ? Carbon::parse("$tanggal {$jamPulang}:00") : null;

        $jamMasukNormal  = Carbon::parse("$tanggal {$shift->jam_masuk_normal}");
        $jamPulangNormal = Carbon::parse("$tanggal {$shift->jam_pulang_normal}");

        $shiftMalam = $shift->jam_pulang_normal < $shift->jam_masuk_normal;

        if ($shiftMalam) {
            $jamPulangNormal->addDay();
            if ($jamPulangDt && $jamMasukDt && $jamPulangDt->lt($jamMasukDt)) {
                $jamPulangDt->addDay();
            }
        }

        // TELAT
        $statusTelat = false;
        $menitTelat  = 0;

        if ($jamMasukDt && $jamMasukDt->gt($jamMasukNormal)) {
            $statusTelat = true;
            $menitTelat  = $jamMasukNormal->diffInMinutes($jamMasukDt);
        }

        // LEMBUR
        $statusLembur = false;
        $menitLembur  = 0;

        if ($jamPulangDt && $jamPulangDt->gt($jamPulangNormal)) {
            $selisih = $jamPulangNormal->diffInMinutes($jamPulangDt);
            if ($selisih >= $shift->minimal_lembur_menit) {
                $statusLembur = true;
                $menitLembur  = $selisih;
            }
        }

        // TOTAL MENIT KERJA
        $totalMenitKerja = null;
        if ($jamMasukDt && $jamPulangDt) {
            $total = $jamMasukDt->diffInMinutes($jamPulangDt);

            if ($jamIstMulai && $jamIstSelesai) {
                $istMulai   = Carbon::parse("$tanggal {$jamIstMulai}:00");
                $istSelesai = Carbon::parse("$tanggal {$jamIstSelesai}:00");

                if ($shiftMalam && $istSelesai->lt($istMulai)) {
                    $istSelesai->addDay();
                }

                $total -= $istMulai->diffInMinutes($istSelesai);
            }

            $totalMenitKerja = max($total, 0);
        }

        return [
            $statusTelat,
            $menitTelat,
            $statusLembur,
            $menitLembur,
            $totalMenitKerja,
        ];
    }

protected function tentukanShiftDariWaktuFinger($waktuFinger): ?Shift
{
    $dt   = \Carbon\Carbon::parse($waktuFinger);
    $time = $dt->format('H:i:s');

    $hariTipe = $dt->isSaturday() ? 'sabtu' : 'weekday';

    return Shift::where('hari_tipe', $hariTipe)
        ->where(function ($q) use ($time) {
            $q->whereNull('range_masuk_mulai')
              ->orWhere('range_masuk_mulai', '<=', $time);
        })
        ->where(function ($q) use ($time) {
            $q->whereNull('range_masuk_selesai')
              ->orWhere('range_masuk_selesai', '>=', $time);
        })
        ->orderBy('id')
        ->first();
}

    protected function tentukanJamMasukIstirahatPulang(Collection $logKaryawan, Shift $shift): array
    {
        $logKaryawan = $logKaryawan->sortBy('waktu_finger')->values();

        $jamMasuk   = null;
        $jamPulang  = null;
        $istMulai   = null;
        $istSelesai = null;

        $rangeMasukMulai  = $shift->range_masuk_mulai;
        $rangeMasukSelesai= $shift->range_masuk_selesai;
        $rangePulangMulai = $shift->range_pulang_mulai;
        $rangePulangSelesai= $shift->range_pulang_selesai;

        foreach ($logKaryawan as $log) {
            $time = Carbon::parse($log->waktu_finger)->format('H:i:s');

            if ($rangeMasukMulai && $rangeMasukSelesai) {
                if ($time >= $rangeMasukMulai && $time <= $rangeMasukSelesai) {
                    $jamMasuk = $log->waktu_finger;
                    break;
                }
            } else {
                $jamMasuk = $logKaryawan->first()->waktu_finger;
                break;
            }
        }

        if (!$jamMasuk) {
            $jamMasuk = $logKaryawan->first()->waktu_finger;
        }

        foreach ($logKaryawan->reverse() as $log) {
            $time = Carbon::parse($log->waktu_finger)->format('H:i:s');

            if ($rangePulangMulai && $rangePulangSelesai) {
                if ($time >= $rangePulangMulai && $time <= $rangePulangSelesai) {
                    $jamPulang = $log->waktu_finger;
                    break;
                }
            } else {
                $jamPulang = $logKaryawan->last()->waktu_finger;
                break;
            }
        }

        if (!$jamPulang) {
            $jamPulang = $logKaryawan->last()->waktu_finger;
        }

        $middleLogs = $logKaryawan->filter(function ($log) use ($jamMasuk, $jamPulang) {
            return $log->waktu_finger != $jamMasuk && $log->waktu_finger != $jamPulang;
        })->values();

        if ($middleLogs->count() >= 1) {
            $istMulai = $middleLogs->get(0)->waktu_finger;
        }

        if ($middleLogs->count() >= 2) {
            $istSelesai = $middleLogs->get(1)->waktu_finger;
        }

        return [
            'jam_masuk'            => $jamMasuk,
            'jam_istirahat_mulai'  => $istMulai,
            'jam_istirahat_selesai'=> $istSelesai,
            'jam_pulang'           => $jamPulang,
        ];
    }
}
