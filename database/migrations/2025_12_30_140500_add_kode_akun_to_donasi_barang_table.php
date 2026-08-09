<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('donasi_barang', function (Blueprint $table) {
            // Add nullable column for revenue account
            $table->string('kode_akun', 20)->nullable()->after('kode_donatur');
            
            // Add foreign key constraint
            $table->foreign('kode_akun')
                  ->references('kode_akun')
                  ->on('daftar_akun')
                  ->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::table('donasi_barang', function (Blueprint $table) {
            $table->dropForeign(['kode_akun']);
            $table->dropColumn('kode_akun');
        });
    }
};
