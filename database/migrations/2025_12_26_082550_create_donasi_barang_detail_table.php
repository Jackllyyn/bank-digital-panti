<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('donasi_barang_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('donasi_barang_id')->constrained('donasi_barang')->onDelete('cascade');
            $table->foreignId('barang_id')->constrained('barang')->onDelete('restrict');
            $table->decimal('qty', 12, 2);
            $table->text('deskripsi_barang')->nullable(); // merk, kondisi, dll
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('donasi_barang_detail');
    }
};