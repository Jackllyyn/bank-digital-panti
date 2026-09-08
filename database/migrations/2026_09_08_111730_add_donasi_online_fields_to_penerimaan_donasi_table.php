<?php
// database/migrations/xxxx_xx_xx_xxxxxx_add_donasi_online_fields_to_penerimaan_donasi_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('penerimaan_donasi', function (Blueprint $table) {
            $table->string('order_id')->nullable()->after('no_transaksi');
            $table->string('payment_status')->default('pending')->after('cara_bayar');
            $table->string('snap_token')->nullable()->after('payment_status');
            $table->text('payment_response')->nullable()->after('snap_token');
            $table->timestamp('paid_at')->nullable()->after('payment_response');
        });
    }

    public function down()
    {
        Schema::table('penerimaan_donasi', function (Blueprint $table) {
            $table->dropColumn(['order_id', 'payment_status', 'snap_token', 'payment_response', 'paid_at']);
        });
    }
};