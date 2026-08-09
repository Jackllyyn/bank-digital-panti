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
    Schema::create('penerimaan_donasi', function (Blueprint $table) {
        $table->id();
        $table->string('no_transaksi', 30)->unique();
        $table->date('tanggal');
        $table->string('kode_donatur', 20)->nullable();
        $table->string('kode_pendapatan', 20)->nullable();
        $table->string('keterangan')->nullable();
        $table->decimal('jumlah', 15, 2);
        $table->enum('cara_bayar', ['tunai','transfer']);
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->timestamps();

        $table->foreign('kode_donatur')->references('kode_donatur')->on('donatur')->onDelete('set null');
        $table->foreign('kode_pendapatan')->references('kode_akun')->on('daftar_akun');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penerimaan_donasi');
    }
};
