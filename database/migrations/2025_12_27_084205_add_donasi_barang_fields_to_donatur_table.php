<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('donatur', function (Blueprint $table) {
        $table->decimal('total_qty_donasi_barang', 12, 2)->default(0)->after('klasifikasi');
        $table->decimal('total_nilai_donasi_barang', 15, 2)->default(0)->after('total_qty_donasi_barang');
    });
}

public function down()
{
    Schema::table('donatur', function (Blueprint $table) {
        $table->dropColumn(['total_qty_donasi_barang', 'total_nilai_donasi_barang']);
    });
}
};
