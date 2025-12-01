<?php

namespace App\Exports;

use App\Models\Absen;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AbsenRekapExport implements FromCollection, WithHeadings, WithMapping
{
    protected string $tanggal;

    public function __construct(string $tanggal)
    {
        $this->tanggal = $tanggal;
    }

    public function collection()
    {
        return Absen::with(['karyawan', 'shift'])
            ->whereDate('tanggal', $this->tanggal)
            ->orderBy('jam_masuk')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Nama',
            'Tanggal',
            'Shift',
            'Jam Masuk',
            'Istirahat Mulai',
            'Istirahat Selesai',
            'Jam Pulang',
            'Telat (menit)',
            'Lembur (menit)',
            'Total Menit Kerja',
            'Keterangan',
        ];
    }

    public function map($absen): array
    {
        return [
            $absen->karyawan->nama ?? '',
            $absen->tanggal,
            $absen->shift->nama_shift ?? '',
            $absen->jam_masuk,
            $absen->jam_istirahat_mulai,
            $absen->jam_istirahat_selesai,
            $absen->jam_pulang,
            $absen->menit_telat,
            $absen->menit_lembur,
            $absen->total_menit_kerja,
            $absen->keterangan,
        ];
    }
}
