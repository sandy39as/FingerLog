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
    Schema::create('shift_kerja', function (Blueprint $table) {
        $table->id();

        $table->string('nama_shift');                 // contoh: Shift 1 / Pagi
        $table->time('jam_masuk');                    // jam masuk standar
        $table->time('jam_keluar_istirahat')->nullable(); // boleh kosong
        $table->time('jam_masuk_istirahat')->nullable();
        $table->time('jam_pulang');                   // jam pulang standar

        $table->integer('toleransi_telat_menit')->default(0); // misal 10 menit

        $table->timestamps();
    });
}

};
