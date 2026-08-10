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
        Schema::create('mood_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mood_id')->constrained('moods')->cascadeOnDelete();
            $table->string('visitor_name')->nullable();
            $table->string('visitor_instagram')->nullable();
            $table->string('selected_answer')->nullable();
            $table->string('ip_address')->nullable();
            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('mood_submissions');
    }
};