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
        Schema::create('asset_items', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // Kode Aset
            $table->string('name'); // Nama Barang
            $table->string('brand')->nullable(); // Tipe / Merk
            $table->unsignedBigInteger('department_id')->nullable();
            $table->unsignedBigInteger('location_id')->nullable();
            $table->unsignedBigInteger('room_id')->nullable();
            $table->string('unit')->default('Pcs'); // Satuan
            $table->integer('quantity')->default(1);
            $table->string('status')->default('Baik'); // Baik, Rusak Ringan, Dalam Servis
            $table->string('pic')->nullable(); // Penanggung Jawab
            $table->string('image')->nullable(); // Foto fisik barang
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset_items');
    }
};
