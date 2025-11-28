<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShiftKerja extends Model
{
    use HasFactory;

    protected $table = 'shift_kerja';

    protected $fillable = [
        'nama_shift',
        'jam_masuk',
        'jam_pulang',
        'jam_istirahat_mulai',
        'jam_istirahat_selesai',
        'toleransi_telat_menit',
    ];
}
