<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AbsenMentah extends Model
{
    use HasFactory;

    protected $table = 'absen_mentahs';

    protected $fillable = [
        'karyawan_id',
        'tanggal',
        'waktu_finger',
        'sumber',
        'no_mesin',
    ];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }
}
