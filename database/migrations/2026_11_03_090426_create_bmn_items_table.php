<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('bmn_items', function (Blueprint $table) {
            $table->id();
            $table->string('gol')->nullable();
            $table->string('bid')->nullable();
            $table->string('kel')->nullable();
            $table->string('sub_kel')->nullable();
            $table->string('sub_sub_kel')->nullable();
            $table->string('code')->unique(); // Gabungan kode lengkap
            $table->string('sat');
            $table->string('name'); // Nama Barang / Uraian
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bmn_items');
    }
};