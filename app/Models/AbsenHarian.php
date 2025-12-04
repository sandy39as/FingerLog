<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AbsenHarian extends Model
{
    protected $table = 'absen_harian';

    protected $fillable = [
        'tanggal',
        'id_finger',
        'karyawan_id',
        'shift',
        'jam_masuk',
        'jam_istirahat_keluar',
        'jam_istirahat_masuk',
        'jam_pulang',
        'telat_menit',
    ];

    protected $casts = [
        'tanggal'             => 'date',
        'jam_masuk'           => 'datetime',
        'jam_istirahat_keluar'=> 'datetime',
        'jam_istirahat_masuk' => 'datetime',
        'jam_pulang'          => 'datetime',
    ];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }
}
