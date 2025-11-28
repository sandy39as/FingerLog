<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    use HasFactory;

    protected $table = 'karyawan';

    protected $fillable = [
        'departemen_id',
        'id_finger',
        'nik',
        'nama',
        'jabatan',
        'status_karyawan'
    ];

    public function departemen()
    {
        return $this->belongsTo(Departemen::class);
    }
}
