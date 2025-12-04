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
    Schema::create('absen_harian', function (Blueprint $table) {
        $table->id();

        $table->date('tanggal');              // tanggal kerja (kalender)
        $table->string('id_finger', 50);      // id fingerprint
        $table->foreignId('karyawan_id')->nullable()->constrained('karyawan');

        $table->tinyInteger('shift')->nullable(); // 1,2,3

        $table->dateTime('jam_masuk')->nullable();
        $table->dateTime('jam_istirahat_keluar')->nullable();
        $table->dateTime('jam_istirahat_masuk')->nullable();
        $table->dateTime('jam_pulang')->nullable();

        $table->integer('telat_menit')->default(0);

        $table->timestamps();

        $table->unique(['tanggal', 'id_finger']); // 1 row per hari per orang
    });
}

};
