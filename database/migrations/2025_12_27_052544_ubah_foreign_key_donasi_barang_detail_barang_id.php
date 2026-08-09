<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('donasi_barang_detail', function (Blueprint $table) {
            // Drop foreign key lama
            $table->dropForeign(['barang_id']);

            // Tambah ulang dengan cascade
            $table->foreign('barang_id')
                  ->references('id')
                  ->on('barang')
                  ->onDelete('cascade');  // ← ini yang baru
        });
    }

    public function down(): void
    {
        Schema::table('donasi_barang_detail', function (Blueprint $table) {
            $table->dropForeign(['barang_id']);
            $table->foreign('barang_id')->references('id')->on('barang')->onDelete('restrict');
        });
    }
};