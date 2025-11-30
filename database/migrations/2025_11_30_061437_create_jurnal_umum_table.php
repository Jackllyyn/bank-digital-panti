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
    Schema::create('jurnal_umum', function (Blueprint $table) {
        $table->id();
        $table->date('tanggal');
        $table->string('no_transaksi', 30);
        $table->string('no_bukti', 50)->nullable();
        $table->text('uraian');
        $table->string('kode_akun_debet', 20);
        $table->string('kode_akun_kredit', 20);
        $table->decimal('jumlah', 15, 2);
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->timestamps();

        $table->foreign('kode_akun_debet')->references('kode_akun')->on('daftar_akun');
        $table->foreign('kode_akun_kredit')->references('kode_akun')->on('daftar_akun');
        $table->index('tanggal');
        $table->index('no_transaksi');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jurnal_umum');
    }
};
