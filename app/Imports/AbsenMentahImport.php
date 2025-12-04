<?php

namespace App\Imports;

use App\Models\AbsenMentah;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AbsenMentahImport implements ToModel, WithHeadingRow
{
    protected string $sumberFile;

    public function __construct(string $sumberFile = '')
    {
        $this->sumberFile = $sumberFile;
    }

    public function model(array $row)
    {
        // Expect header: id_finger, tanggal_waktu, jenis_absen
        // Contoh: 1001 | 2025-11-28 06:45:10 | 1

        if (empty($row['id_finger']) || empty($row['tanggal_waktu'])) {
            return null; // skip baris kosong
        }

        // Normalisasi datetime
        $tanggalWaktu = Carbon::parse($row['tanggal_waktu']);

        // Normalisasi jenis absen (1–4)
        $jenis = $row['jenis_absen'] ?? null;

        return new AbsenMentah([
            'id_finger'    => trim($row['id_finger']),
            'tanggal_waktu'=> $tanggalWaktu,
            'jenis_absen'  => is_numeric($jenis) ? (int)$jenis : null,
            'sumber_file'  => $this->sumberFile,
        ]);
    }
}
