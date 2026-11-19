<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('institution_kops', function (Blueprint $table) {
            $table->id();
            $table->string('logo')->nullable();
            
            // 5 Baris Identitas
            $table->string('line_1')->nullable();
            $table->string('line_2')->nullable();
            $table->string('line_3')->nullable();
            $table->string('line_4')->nullable();
            $table->string('line_5')->nullable();

            // Pengaturan Font & Ukuran per Baris (Opsional / Global)
            $table->string('font_family')->default('Arial, sans-serif');
            $table->string('size_1')->default('14px');
            $table->string('size_2')->default('16px');
            $table->string('size_3')->default('13px');
            $table->string('size_4')->default('11px');
            $table->string('size_5')->default('11px');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('institution_kops');
    }
};