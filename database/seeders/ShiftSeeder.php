<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Shift;

class ShiftSeeder extends Seeder
{
    public function run(): void
    {
        Shift::query()->delete();

        // =========================
        // WEEKDAY (Senin–Jumat)
        // =========================

        // Shift 1: 07.00 - 15.00
        Shift::create([
            'nama_shift'           => 'Shift 1 Weekday',
            'hari_tipe'            => 'weekday',
            'jam_masuk_normal'     => '07:00:00',
            'jam_pulang_normal'    => '15:00:00',
            'range_masuk_mulai'    => '05:00:00',
            'range_masuk_selesai'  => '09:00:00',
            'range_pulang_mulai'   => '13:00:00',
            'range_pulang_selesai' => '18:00:00',
            'minimal_lembur_menit' => 30,
        ]);

        // Shift 2: 15.00 - 23.00
        Shift::create([
            'nama_shift'           => 'Shift 2 Weekday',
            'hari_tipe'            => 'weekday',
            'jam_masuk_normal'     => '15:00:00',
            'jam_pulang_normal'    => '23:00:00',
            'range_masuk_mulai'    => '13:00:00',
            'range_masuk_selesai'  => '17:00:00',
            'range_pulang_mulai'   => '21:00:00',
            'range_pulang_selesai' => '23:59:59',
            'minimal_lembur_menit' => 30,
        ]);

        // Shift 3: 23.00 - 07.00
        Shift::create([
            'nama_shift'           => 'Shift 3 Weekday',
            'hari_tipe'            => 'weekday',
            'jam_masuk_normal'     => '23:00:00',
            'jam_pulang_normal'    => '07:00:00',
            'range_masuk_mulai'    => '21:00:00',
            'range_masuk_selesai'  => '23:59:59',
            'range_pulang_mulai'   => '00:00:00',
            'range_pulang_selesai' => '09:00:00',
            'minimal_lembur_menit' => 30,
        ]);

        // =========================
        // SABTU
        // =========================

        // Shift 1: 07.00 - 13.00
        Shift::create([
            'nama_shift'           => 'Shift 1 Sabtu',
            'hari_tipe'            => 'sabtu',
            'jam_masuk_normal'     => '07:00:00',
            'jam_pulang_normal'    => '13:00:00',
            'range_masuk_mulai'    => '05:00:00',
            'range_masuk_selesai'  => '09:00:00',
            'range_pulang_mulai'   => '11:00:00',
            'range_pulang_selesai' => '15:00:00',
            'minimal_lembur_menit' => 30,
        ]);

        // Shift 2: 13.00 - 19.00
        Shift::create([
            'nama_shift'           => 'Shift 2 Sabtu',
            'hari_tipe'            => 'sabtu',
            'jam_masuk_normal'     => '13:00:00',
            'jam_pulang_normal'    => '19:00:00',
            'range_masuk_mulai'    => '11:00:00',
            'range_masuk_selesai'  => '15:00:00',
            'range_pulang_mulai'   => '17:00:00',
            'range_pulang_selesai' => '21:00:00',
            'minimal_lembur_menit' => 30,
        ]);

        // Shift 3: 19.00 - 01.00
        Shift::create([
            'nama_shift'           => 'Shift 3 Sabtu',
            'hari_tipe'            => 'sabtu',
            'jam_masuk_normal'     => '19:00:00',
            'jam_pulang_normal'    => '01:00:00',
            'range_masuk_mulai'    => '17:00:00',
            'range_masuk_selesai'  => '21:00:00',
            'range_pulang_mulai'   => '23:00:00',
            'range_pulang_selesai' => '03:00:00',
            'minimal_lembur_menit' => 30,
        ]);

        // Shift 4: 01.00 - 07.00
        Shift::create([
            'nama_shift'           => 'Shift 4 Sabtu',
            'hari_tipe'            => 'sabtu',
            'jam_masuk_normal'     => '01:00:00',
            'jam_pulang_normal'    => '07:00:00',
            'range_masuk_mulai'    => '23:00:00',
            'range_masuk_selesai'  => '03:00:00',
            'range_pulang_mulai'   => '05:00:00',
            'range_pulang_selesai' => '09:00:00',
            'minimal_lembur_menit' => 30,
        ]);
    }
}
