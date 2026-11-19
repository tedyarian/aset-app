<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabel Mutasi Aset
        Schema::create('asset_mutations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asset_item_id')->constrained('assets')->onDelete('cascade');
            $table->unsignedBigInteger('from_room_id')->nullable();
            $table->unsignedBigInteger('to_room_id')->nullable();
            $table->string('from_pic')->nullable();
            $table->string('to_pic')->nullable();
            $table->date('mutation_date');
            $table->text('reason')->nullable();
            $table->timestamps();
        });

        // Tabel Peminjaman Aset
        Schema::create('asset_loans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asset_item_id')->constrained('assets')->onDelete('cascade');
            $table->string('borrower_name');
            $table->string('borrower_dept')->nullable();
            $table->date('loan_date');
            $table->date('due_date');
            $table->date('return_date')->nullable();
            $table->enum('status', ['Dipinjam', 'Dikembalikan', 'Terlambat'])->default('Dipinjam');
            $table->string('condition_before')->default('Baik');
            $table->string('condition_after')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // Tabel Perawatan / Maintenance Aset
        Schema::create('asset_maintenances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asset_item_id')->constrained('assets')->onDelete('cascade');
            $table->date('maintenance_date');
            $table->string('maintenance_type');
            $table->decimal('cost', 15, 2)->default(0);
            $table->string('vendor_or_technician');
            $table->text('description');
            $table->enum('status', ['Proses', 'Selesai', 'Dibatalkan'])->default('Proses');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asset_maintenances');
        Schema::dropIfExists('asset_loans');
        Schema::dropIfExists('asset_mutations');
    }
};