<?php

namespace App\Exports;

use App\Models\AbsenHarian;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class RekapAbsenHarianExport implements FromCollection, WithHeadings, WithMapping
{
    protected string $tanggal;

    public function __construct(string $tanggal)
    {
        $this->tanggal = $tanggal;
    }

    public function collection()
    {
        return AbsenHarian::with(['karyawan.departemen'])
            ->whereDate('tanggal', $this->tanggal)
            ->orderBy('jam_masuk')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'ID Finger',
            'Nama Karyawan',
            'Departemen',
            'Shift',
            'Jam Masuk',
            'Keluar Istirahat',
            'Masuk Istirahat',
            'Jam Pulang',
            'Telat (menit)',
        ];
    }

    public function map($row): array
    {
        return [
            $row->tanggal?->format('Y-m-d'),
            $row->id_finger,
            $row->karyawan->nama ?? '',
            $row->karyawan->departemen->nama ?? '',
            $row->shift ? 'Shift '.$row->shift : '',
            $row->jam_masuk?->format('H:i'),
            $row->jam_istirahat_keluar?->format('H:i'),
            $row->jam_istirahat_masuk?->format('H:i'),
            $row->jam_pulang?->format('H:i'),
            $row->telat_menit,
        ];
    }
}
