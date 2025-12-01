<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Karyawan;

class KaryawanSeeder extends Seeder
{
    public function run(): void
    {
        // Jangan truncate kalau sudah pakai relasi di mana-mana.
        // Kalo mau bersih, bisa pakai: Karyawan::query()->delete();

        Karyawan::firstOrCreate(
            ['nik' => 'KRY001'],
            ['nama' => 'Budi Santoso', 'bagian' => 'Produksi', 'jabatan' => 'Operator']
        );

        Karyawan::firstOrCreate(
            ['nik' => 'KRY002'],
            ['nama' => 'Siti Aminah', 'bagian' => 'Produksi', 'jabatan' => 'Operator']
        );
    }
}
