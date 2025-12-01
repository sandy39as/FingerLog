<?php

namespace App\Imports;

use App\Models\Karyawan;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class KaryawanImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        if (!isset($row['nama']) || trim($row['nama']) === '') {
            return null;
        }

        $departemen = $row['departemen'] ?? null;

        return Karyawan::updateOrCreate(
            ['nama' => trim($row['nama'])], 
            [
                'nik'        => $row['nik'] ?? null,  
                'bagian' => $departemen,
                'jabatan'    => null,
                'status'     => 1,           
            ]
        );
    }
}
