<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('penerimaan_donasi', function (Blueprint $table) {
            $table->string('kode_akun_pendapatan', 10)->nullable()->after('jumlah');
            $table->foreign('kode_akun_pendapatan')
                  ->references('kode_akun')
                  ->on('daftar_akun')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('penerimaan_donasi', function (Blueprint $table) {
            $table->dropForeign(['kode_akun_pendapatan']);
            $table->dropColumn('kode_akun_pendapatan');
        });
    }
};