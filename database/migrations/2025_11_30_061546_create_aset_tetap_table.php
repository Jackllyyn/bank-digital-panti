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
    Schema::create('aset_tetap', function (Blueprint $table) {
        $table->string('kode_aset', 20)->primary();
        $table->string('nama_aset', 150);
        $table->date('tanggal_perolehan');
        $table->decimal('harga_perolehan', 15, 2);
        $table->integer('masa_manfaat_tahun')->nullable();
        $table->decimal('nilai_residu', 15, 2)->default(0);
        $table->decimal('akumulasi_penyusutan', 15, 2)->default(0);
        $table->text('keterangan')->nullable();
        $table->string('foto')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aset_tetap');
    }
};
