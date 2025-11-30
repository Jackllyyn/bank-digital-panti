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
    Schema::create('pengeluaran', function (Blueprint $table) {
        $table->id();
        $table->date('tanggal');
        $table->string('kode_akun', 20);
        $table->text('keterangan');
        $table->decimal('jumlah', 15, 2);
        $table->string('no_bukti', 50)->nullable();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->timestamps();

        $table->foreign('kode_akun')->references('kode_akun')->on('daftar_akun');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengeluaran');
    }
};
