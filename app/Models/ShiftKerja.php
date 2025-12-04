<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShiftKerja extends Model
{
    protected $table = 'shift_kerja';

    protected $fillable = [
        'nama_shift',
        'jam_masuk',
        'jam_keluar_istirahat',
        'jam_masuk_istirahat',
        'jam_pulang',
        'toleransi_telat_menit',
    ];

    protected $casts = [
        'jam_masuk'             => 'datetime:H:i',
        'jam_keluar_istirahat'  => 'datetime:H:i',
        'jam_masuk_istirahat'   => 'datetime:H:i',
        'jam_pulang'            => 'datetime:H:i',
    ];
}
