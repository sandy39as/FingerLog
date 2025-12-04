<?php

namespace App\Imports;

use App\Models\Karyawan;
use App\Models\Departemen;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class KaryawanImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Buat departemen kalau belum ada
        $departemen = null;
        if (!empty($row['departemen'])) {
            $departemen = Departemen::firstOrCreate([
                'nama' => strtoupper($row['departemen'])
            ]);
        }

        return Karyawan::updateOrCreate(
            ['id_finger' => $row['id_finger']],
            [
                'nik'            => $row['nik'] ?? null,
                'nama'           => $row['nama'] ?? 'TANPA NAMA',
                'jabatan'        => $row['jabatan'] ?? null,
                'status_karyawan' => $row['status'] ?? 'aktif',
                'departemen_id'  => $departemen->id ?? null
            ]
        );
    }
}
