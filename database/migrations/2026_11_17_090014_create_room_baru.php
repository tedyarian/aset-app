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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama Ruang
            $table->string('sign_tempat');
            $table->date('sign_date');
            $table->string('location')->nullable(); // Tempat / Lokasi Gedung
            
            // Penanggung Jawab Ruangan
            $table->string('pic_jabatan')->nullable();
            $table->string('pic_name')->nullable();
            $table->string('pic_nip')->nullable();

            // Pimpinan (Dekan / Ketua / Kepala Unit)
            $table->string('leader_jabatan')->nullable();
            $table->string('leader_name')->nullable();
            $table->string('leader_nip')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
