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
        Schema::create('kaskecil', function (Blueprint $table) {
            $table->id();
            $table->string('no_transaksi', 20)->unique();
            $table->date('tanggal');
            $table->string('keterangan', 255);
            $table->string('kode_akund', 25);
            $table->string('kode_akunk', 25);
            $table->decimal('jumlah', 15, 2);
            $table->string('no_bukti', 50);
            $table->foreignId('user_id'); // Auditor Trail: siapa yang input
            $table->timestamps();

 // Index untuk performa pencarian jurnal
            $table->foreign('kode_akund')->references('kode_akun')->on('daftar_akun');
            $table->foreign('kode_akunk')->references('kode_akun')->on('daftar_akun');
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kaskecil');
    }
};
