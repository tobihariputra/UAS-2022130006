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
        Schema::create('rutes', function (Blueprint $table) {
            $table->id();
            $table->string('nama_rute'); // Nama rute
            $table->foreignId('stasiun_asal_id')->constrained('stasiuns')->onDelete('cascade'); // Foreign key ke stasiuns untuk stasiun asal
            $table->foreignId('stasiun_tujuan_id')->constrained('stasiuns')->onDelete('cascade'); // Foreign key ke stasiuns untuk stasiun tujuan
            $table->timestamps(); // Timestamps untuk created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rutes');
    }
};
