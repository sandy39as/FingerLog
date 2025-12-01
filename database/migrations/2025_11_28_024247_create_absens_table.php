<?php

// database/migrations/2025_01_01_000300_create_absens_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('absens', function (Blueprint $table) {
            $table->id();

            $table->foreignId('karyawan_id')
                  ->constrained('karyawans')
                  ->cascadeOnDelete();

            $table->foreignId('shift_id')
                  ->constrained('shifts')
                  ->cascadeOnDelete();

            $table->date('tanggal');

            // hasil mapping dari absen_mentah
            $table->time('jam_masuk')->nullable();
            $table->time('jam_istirahat_mulai')->nullable();
            $table->time('jam_istirahat_selesai')->nullable();
            $table->time('jam_pulang')->nullable();

            // telat (TIDAK ADA toleransi)
            $table->boolean('status_telat')->default(false);
            $table->unsignedInteger('menit_telat')->default(0);

            // lembur (pakai minimal_lembur_menit dari shift)
            $table->boolean('status_lembur')->default(false);
            $table->unsignedInteger('menit_lembur')->default(0);

            // opsional: total menit kerja
            $table->unsignedInteger('total_menit_kerja')->nullable();

            $table->text('keterangan')->nullable();

            $table->timestamps();

            $table->unique(['karyawan_id', 'tanggal']); // satu rekap per hari per karyawan
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('absens');
    }
};
