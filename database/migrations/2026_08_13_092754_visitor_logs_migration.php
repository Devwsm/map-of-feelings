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
        //
        Schema::create('visitor_logs', function (Blueprint $table) {
            $table->id();
            $table->string('session_id')->unique();
            $table->string('ip_address')->nullable();
            $table->text('user_agent')->nullable();
            $table->string('browser')->nullable();
            $table->string('platform')->nullable();
            $table->string('device_type')->nullable(); // desktop | mobile | tablet
            $table->string('url')->nullable(); // halaman terakhir yang diakses
            $table->string('referer')->nullable();
            $table->timestamps(); // created_at = kunjungan pertama, updated_at = last_seen (dipakai buat status "sedang mengakses")
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('visitor_logs');
    }
};