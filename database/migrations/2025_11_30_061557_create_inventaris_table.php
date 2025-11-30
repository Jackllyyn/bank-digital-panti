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
    Schema::create('inventaris', function (Blueprint $table) {
        $table->string('kode_barang', 20)->primary();
        $table->string('nama_barang', 150);
        $table->string('satuan', 20)->nullable();
        $table->decimal('stok', 10, 2)->default(0);
        $table->decimal('harga_rata2', 15, 2)->default(0);
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
        Schema::dropIfExists('inventaris');
    }
};
