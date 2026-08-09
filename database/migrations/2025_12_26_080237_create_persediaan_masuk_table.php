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
        Schema::create('persediaan_masuk', function (Blueprint $table) {
    $table->id();
    $table->date('tanggal');
    $table->string('no_transaksi', 30)->unique();
    $table->foreignId('barang_id')->constrained('barang')->onDelete('restrict');
    $table->decimal('qty', 12, 2);
    $table->decimal('harga_satuan', 15, 2);
    $table->decimal('total_harga', 15, 2);
    $table->text('keterangan')->nullable();
    $table->foreignId('user_id')->constrained()->onDelete('restrict');
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('persediaan_masuk');
    }
};
