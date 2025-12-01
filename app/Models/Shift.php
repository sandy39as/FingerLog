<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Shift extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_shift',
        'jam_masuk_normal',
        'jam_pulang_normal',
        'range_masuk_mulai',
        'range_masuk_selesai',
        'range_pulang_mulai',
        'range_pulang_selesai',
        'minimal_lembur_menit',
    ];

    public function absens()
    {
        return $this->hasMany(Absen::class);
    }
}
