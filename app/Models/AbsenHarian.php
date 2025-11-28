<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbsenHarian extends Model
{
    use HasFactory;

    protected $table = 'absen_harian';

    protected $fillable = [
        'karyawan_id',
        'shift_id',
        'tanggal',
        'jam_masuk',
        'jam_istirahat_keluar',
        'jam_istirahat_masuk',
        'jam_pulang',
        'durasi_istirahat_menit',
        'total_jam_kerja',
        'telat_menit',
        'lembur_menit',
        'status_harian',
        'catatan',
    ];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }

    public function shift()
    {
        return $this->belongsTo(ShiftKerja::class, 'shift_id');
    }
}
