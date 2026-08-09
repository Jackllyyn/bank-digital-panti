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
        Schema::create('karyawan', function (Blueprint $table) {
            $table->string('nip', 20)->primary();
            $table->string('jenis_karyawan', 50)->nullable();
            $table->string('nama', 150);
            $table->text('alamat_lengkap')->nullable();
            $table->string('kota', 50)->nullable();
            $table->string('telepon', 20)->nullable();
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable();
            $table->enum('klasifikasi', ['tetap', 'tidak tetap'])->nullable();
            $table->date('tanggal_daftar')->useCurrent();
            $table->decimal('gaji_pokok', 20)->nullable();
            $table->decimal('tunjangan', 20)->nullable();
            $table->decimal('potongan_gaji', 20)->nullable();
            $table->string('jabatan', 100)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('karyawan');
    }
};
