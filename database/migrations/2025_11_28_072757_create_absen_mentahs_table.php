<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('absen_mentah', function (Blueprint $table) {
        $table->id();

        // ID fingerprint dari mesin
        $table->string('id_finger', 50);

        // Waktu tap di mesin
        $table->dateTime('tanggal_waktu');

        // Jenis absen: 1=Datang, 2=Keluar Istirahat, 3=Selesai Istirahat, 4=Pulang
        $table->tinyInteger('jenis_absen')->nullable();

        // Info tambahan (opsional)
        $table->string('sumber_file')->nullable(); // nama file Excel asal
        $table->string('keterangan')->nullable();

        $table->timestamps();
    });
}

};
