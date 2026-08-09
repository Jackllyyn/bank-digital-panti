<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('donasi_barang', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->string('no_transaksi', 30)->unique();
            $table->string('kode_donatur', 20)->nullable();
            $table->foreign('kode_donatur')->references('kode_donatur')->on('donatur')->onDelete('set null');
            $table->text('keterangan')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('donasi_barang');
    }
};