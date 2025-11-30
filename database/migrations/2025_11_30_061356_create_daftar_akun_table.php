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
    Schema::create('daftar_akun', function (Blueprint $table) {
        $table->string('kode_akun', 200)->primary();
        $table->string('nama_akun', 150);
        $table->enum('kelompok', ['ASET','LIABILITAS','EKUITAS','PENDAPATAN','BEBAN']);
        $table->enum('posisi_saldo', ['DEBET','KREDIT']);
        $table->decimal('saldo_awal', 15, 2)->default(0);
        $table->year('tahun')->default(date('Y'));
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daftar_akun');
    }
};
