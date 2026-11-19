<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabel Sesi Audit / Stock Opname
        Schema::create('asset_audit_sessions', function (Blueprint $table) {
            $table->id();
            $table->string('session_name'); // Contoh: Stok Opname Gedung A - Q3 2026
            $table->date('start_date');
            $table->date('end_date');
            $table->enum('status', ['Draft', 'Berlangsung', 'Selesai'])->default('Berlangsung');
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // Tabel Detail Hasil Scan / Audit per Aset
        Schema::create('asset_audit_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('audit_session_id')->constrained('asset_audit_sessions')->onDelete('cascade');
            $table->foreignId('asset_item_id')->constrained('assets')->onDelete('cascade');
            $table->timestamp('scanned_at')->nullable();
            $table->enum('audit_status', ['Ditemukan', 'Hilang', 'Tidak Sesuai Lokasi'])->default('Ditemukan');
            $table->string('scanned_by')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asset_audit_items');
        Schema::dropIfExists('asset_audit_sessions');
    }
};