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
    Schema::create('tikets', function (Blueprint $table) {
        $table->id();
        $table->foreignId('jadwal_id')->constrained('jadwals')->onDelete('cascade');
        $table->string('kode_tiket');
        $table->string('kelas_tiket');
        $table->decimal('harga', 10, 2);
        $table->integer('jumlah');
        $table->enum('status', ['available', 'unavailable'])->default('available');
        $table->timestamps();

        // Add composite unique constraint for jadwal_id, kelas_tiket, and kode_tiket
        $table->unique(['jadwal_id', 'kelas_tiket', 'kode_tiket']);
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tikets');
    }
};
