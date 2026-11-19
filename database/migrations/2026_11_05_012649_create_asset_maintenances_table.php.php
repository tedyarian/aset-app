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
        Schema::create('asset_maintenances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asset_item_id')->constrained('assets')->onDelete('cascade');
            $table->date('maintenance_date');
            $table->string('maintenance_type'); // Servis Berkala, Perbaikan Kerusakan
            $table->decimal('cost', 15, 2)->default(0);
            $table->string('vendor_or_technician');
            $table->text('description');
            $table->enum('status', ['Proses', 'Selesai', 'Dibatalkan'])->default('Proses');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
