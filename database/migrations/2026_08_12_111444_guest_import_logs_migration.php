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
        // Riwayat setiap kali import tamu benar-benar dieksekusi (bukan sekadar
        // preview). Dipakai buat audit: kalau ada data aneh, tinggal lihat siapa
        // yang import, file apa, dan jam berapa.
        Schema::create('guest_import_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('original_filename');
            $table->unsignedInteger('total_rows');
            $table->unsignedInteger('imported_count');
            $table->unsignedInteger('skipped_count');
            $table->json('errors')->nullable(); // list pesan baris yang dilewati
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guest_import_logs');
    }
};