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
    Schema::create('saldo_awal', function (Blueprint $table) {
        $table->id();
        $table->string('kode_akun', 20);
        $table->year('tahun');
        $table->decimal('saldo', 15, 2)->default(0);
        $table->timestamps();

        $table->foreign('kode_akun')->references('kode_akun')->on('daftar_akun')->onDelete('cascade');
        $table->unique(['kode_akun', 'tahun']);
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('saldo_awal');
    }
};
