<?php

// database/migrations/2025_01_01_000200_create_absen_mentahs_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('absen_mentahs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('karyawan_id')
                  ->constrained('karyawans')
                  ->cascadeOnDelete();
            $table->string('nama')->nullable();
            $table->date('tanggal');      // diambil dari waktu_finger
            $table->dateTime('waktu_finger');

            $table->string('sumber')->nullable();   // nama file excel / keterangan import
            $table->string('no_mesin')->nullable(); // kalau ada kode/nomor mesin finger

            $table->timestamps();

            // index buat percepat query per karyawan + tanggal
            $table->index(['karyawan_id', 'tanggal']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('absen_mentahs');
    }
};
