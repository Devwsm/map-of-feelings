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
        Schema::create('presscon_guests', function (Blueprint $table) {
            $table->id('id_guest');

            // Diisi ADMIN saat bikin/edit undangan
            $table->string('slug')->unique(); // format: WSM-{KODE_KATEGORI}-{NAMA}
            $table->string('name');
            $table->enum('category', [
                'Crew',
                'Media',
                'Partner',
                'Venue',
                'Colleague',
                'DJ/Musician Colleague',
                'Artist/Production Team',
                'Inner Circle',
            ]);
            $table->string('group')->nullable();
            $table->unsignedInteger('max_pax')->default(1);
            $table->boolean('requires_name')->default(false);
            $table->text('details')->nullable(); // catatan internal admin, gak ditampilkan ke tamu

            // Diisi TAMU lewat form RSVP di halaman guest
            $table->string('submitted_name')->nullable();
            $table->enum('rsvp_status', ['pending', 'hadir', 'tidak_hadir'])->default('pending');
            $table->text('note')->nullable();
            $table->unsignedInteger('confirmed_pax')->nullable();

            // Diisi PANITIA pas hari-H (check-in)
            $table->boolean('checked_in')->default(false);
            $table->timestamp('arrival_time')->nullable();

            // Status generate QR (diproses via queue, bukan sinkron pas insert)
            $table->boolean('qr_generated')->default(false);
            $table->string('qr_path')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('presscon_guests');
    }
};