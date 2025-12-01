<?php

// database/migrations/2025_01_01_000100_create_shifts_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shifts', function (Blueprint $table) {
            $table->id();
            $table->string('nama_shift'); // contoh: "Shift 1"

            // jam kerja normal
            $table->time('jam_masuk_normal');   // contoh: 07:00:00
            $table->time('jam_pulang_normal');  // contoh: 15:00:00

            // range baca finger untuk shift ini
            $table->time('range_masuk_mulai')->nullable();   // contoh: 05:00:00
            $table->time('range_masuk_selesai')->nullable(); // contoh: 09:00:00
            $table->time('range_pulang_mulai')->nullable();  // contoh: 13:00:00
            $table->time('range_pulang_selesai')->nullable();// contoh: 18:00:00

            // lembur
            $table->unsignedInteger('minimal_lembur_menit')->default(30);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shifts');
    }
};
