<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Absen extends Model
{
    use HasFactory;

    protected $fillable = [
        'karyawan_id',
        'shift_id',
        'tanggal',
        'jam_masuk',
        'jam_istirahat_mulai',
        'jam_istirahat_selesai',
        'jam_pulang',
        'status_telat',
        'menit_telat',
        'status_lembur',
        'menit_lembur',
        'total_menit_kerja',
        'keterangan',
    ];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }

    public function shift()
    {
        return $this->belongsTo(Shift::class);
    }
}
