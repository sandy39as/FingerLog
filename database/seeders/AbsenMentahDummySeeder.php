<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AbsenMentah;
use App\Models\Karyawan;
use Carbon\Carbon;

class AbsenMentahDummySeeder extends Seeder
{
    public function run(): void
    {
        $budi = Karyawan::where('nik', 'KRY001')->first();
        if (!$budi) return;

        // Bersihkan log dummy untuk Budi
        AbsenMentah::where('karyawan_id', $budi->id)->delete();

        // Contoh tanggal (ganti sesuai kebutuhan)
        $hari1 = '2025-11-24'; // on time, shift 1
        $hari2 = '2025-11-25'; // telat
        $hari3 = '2025-11-26'; // lembur

        // ===== Hari 1 (ON TIME, sesuai contohmu) =====
        $this->buatLogSet(
            $budi->id,
            $hari1,
            ['06:40:00', '11:05:00', '11:50:00', '14:21:00'],
            'Mesin 1'
        );

        // ===== Hari 2 (TELAT: datang 07:15) =====
        $this->buatLogSet(
            $budi->id,
            $hari2,
            ['07:15:00', '11:10:00', '11:55:00', '14:59:00'],
            'Mesin 1'
        );

        // ===== Hari 3 (LEMBUR: pulang 16:30) =====
        $this->buatLogSet(
            $budi->id,
            $hari3,
            ['06:55:00', '11:03:00', '11:57:00', '16:30:00'],
            'Mesin 1'
        );
    }

    protected function buatLogSet(int $karyawanId, string $tanggal, array $jamList, string $noMesin): void
    {
        foreach ($jamList as $jam) {
            $dt = Carbon::parse("$tanggal $jam");

            AbsenMentah::create([
                'karyawan_id'  => $karyawanId,
                'tanggal'      => $dt->toDateString(),
                'waktu_finger' => $dt,
                'sumber'       => 'dummy_seeder',
                'no_mesin'     => $noMesin,
            ]);
        }
    }
}
