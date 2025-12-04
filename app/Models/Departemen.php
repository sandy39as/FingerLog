<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Departemen extends Model
{
    protected $table = 'departemen';

    protected $fillable = [
        'nama',
        'kode',
    ];

    public function karyawan()
    {
        return $this->hasMany(Karyawan::class);
    }
}
