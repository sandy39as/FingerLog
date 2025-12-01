<?php

namespace App\Imports;

use App\Models\AbsenMentah;
use App\Models\Karyawan;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AbsenMentahImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        if (!isset($row['nama']) || !isset($row['waktu'])) {
            return null;
        }

        $karyawan = Karyawan::where('nama', trim($row['nama']))->first();

        if (!$karyawan) {
            return null;
        }

        $waktu = Carbon::parse($row['waktu']);

        return new AbsenMentah([
            'karyawan_id'  => $karyawan->id,
            'tanggal'      => $waktu->toDateString(),
            'waktu_finger' => $waktu->toDateTimeString(),
            'sumber'       => 'import_excel',
        ]);
    }
}
