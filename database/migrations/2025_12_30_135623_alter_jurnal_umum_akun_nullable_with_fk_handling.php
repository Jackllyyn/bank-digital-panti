<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Drop foreign key dulu (pakai nama constraint yang muncul di error)
        Schema::table('jurnal_umum', function (Blueprint $table) {
            $table->dropForeign(['kode_akun_debet']);
            $table->dropForeign(['kode_akun_kredit']); // jika ada juga untuk kredit
        });

        // 2. Ubah kolom menjadi nullable
        Schema::table('jurnal_umum', function (Blueprint $table) {
            $table->string('kode_akun_debet')->nullable()->change();
            $table->string('kode_akun_kredit')->nullable()->change();
        });

        // 3. Buat ulang foreign key (opsional, tapi direkomendasikan agar integritas tetap terjaga)
        Schema::table('jurnal_umum', function (Blueprint $table) {
            $table->foreign('kode_akun_debet')
                  ->references('kode_akun')
                  ->on('daftar_akun')
                  ->onDelete('restrict')   // atau 'set null' jika mau
                  ->onUpdate('cascade');

            $table->foreign('kode_akun_kredit')
                  ->references('kode_akun')
                  ->on('daftar_akun')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        // Reverse: drop FK baru → ubah kembali not null → buat FK lama
        Schema::table('jurnal_umum', function (Blueprint $table) {
            $table->dropForeign(['kode_akun_debet']);
            $table->dropForeign(['kode_akun_kredit']);
        });

        Schema::table('jurnal_umum', function (Blueprint $table) {
            $table->string('kode_akun_debet')->nullable(false)->change();
            $table->string('kode_akun_kredit')->nullable(false)->change();
        });

        // Buat ulang FK seperti semula jika perlu
    }
};