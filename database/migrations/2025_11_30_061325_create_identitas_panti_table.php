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
    Schema::create('identitas_panti', function (Blueprint $table) {
        $table->id();
        $table->string('nama_yayasan');
        $table->string('nama_panti');
        $table->text('alamat')->nullable();
        $table->string('kota')->nullable();
        $table->string('kode_pos', 10)->nullable();
        $table->string('telepon', 20)->nullable();
        $table->string('email', 100)->nullable();
        $table->string('website')->nullable();
        $table->string('pimpinan')->nullable();
        $table->string('bendahara')->nullable();
        $table->string('logo')->nullable();
        $table->string('npwp', 50)->nullable();
        $table->string('no_rekening', 50)->nullable();
        $table->string('nama_bank')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('identitas_panti');
    }
};
