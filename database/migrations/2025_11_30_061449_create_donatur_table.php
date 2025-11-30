<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('donatur', function (Blueprint $table) {
            $table->string('kode_donatur', 20)->primary();
            $table->string('jenis_donatur', 50)->nullable();
            $table->string('nama', 150);
            $table->text('alamat_lengkap')->nullable();
            $table->string('kota', 50)->nullable();
            $table->string('telepon', 20)->nullable();
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable();
            $table->string('pekerjaan', 100)->nullable();
            $table->enum('klasifikasi', ['tetap', 'tidak tetap'])->nullable();
            $table->date('tanggal_daftar')->useCurrent();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('donatur');
    }
};
