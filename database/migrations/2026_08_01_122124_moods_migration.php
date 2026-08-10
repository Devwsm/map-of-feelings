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
        Schema::create('moods', function (Blueprint $table) {
            $table->id();
            $table->string('mood_key')->unique(); // 'sedih', 'serba-salah', dst — dipakai JS buat identifikasi
            $table->unsignedInteger('sort_order')->default(0);

            $table->string('feeling');
            $table->string('nuance');
            $table->string('song');
            $table->text('question');
            $table->string('choice_1');
            $table->string('choice_2');
            $table->string('choice_3');
            $table->string('choice_4');
            $table->string('coordinate');
            $table->text('why');
            $table->text('affirmation');
            $table->string('weather_text')->nullable();

            $table->string('audio_path')->nullable(); // relatif ke public/, mis. assets/audio/sedih.mp3
            $table->string('artwork_path')->nullable(); // relatif ke public/, mis. assets/artwork/xxx.svg
            $table->string('color_primary', 7)->default('#7aaef7');
            $table->string('color_secondary', 7)->default('#4b82eb');
            $table->string('color_accent', 7)->default('#0954e3');

            $table->string('mof_url')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('moods');
    }
};