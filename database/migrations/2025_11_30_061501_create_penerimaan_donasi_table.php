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
        $table->date('tanggal');
        $table->string('kode_donatur', 20)->nullable();
        $table->enum('jenis', ['zakat','infak','sedekah','wakaf','lainnya']);
        $table->text('keterangan')->nullable();
        $table->decimal('jumlah', 15, 2);
        $table->enum('cara_bayar', ['tunai','transfer','barang']);
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->timestamps();

        $table->foreign('kode_donatur')->references('kode_donatur')->on('donatur')->onDelete('set null');
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
