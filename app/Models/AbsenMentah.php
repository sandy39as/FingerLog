<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AbsenMentah extends Model
{
    protected $table = 'absen_mentah';

    protected $fillable = [
        'id_finger',
        'tanggal_waktu',
        'jenis_absen',
        'sumber_file',
        'keterangan',
    ];

    protected $casts = [
        'tanggal_waktu' => 'datetime',
    ];
}
