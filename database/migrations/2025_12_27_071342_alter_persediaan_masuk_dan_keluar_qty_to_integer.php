<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('persediaan_masuk', function (Blueprint $table) {
            $table->unsignedInteger('qty')->default(0)->change();
        });

        Schema::table('persediaan_keluar', function (Blueprint $table) {
            $table->unsignedInteger('qty')->default(0)->change();
        });
    }

    public function down(): void
    {
        Schema::table('persediaan_masuk', function (Blueprint $table) {
            $table->decimal('qty', 10, 2)->default(0.00)->change();
        });

        Schema::table('persediaan_keluar', function (Blueprint $table) {
            $table->decimal('qty', 10, 2)->default(0.00)->change();
        });
    }
};