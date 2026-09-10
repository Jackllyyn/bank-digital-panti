<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pengurus', function (Blueprint $table) {
            if (!Schema::hasColumn('pengurus', 'email')) {
                $table->string('email')->nullable()->after('jabatan');
            }
            if (!Schema::hasColumn('pengurus', 'telepon')) {
                $table->string('telepon')->nullable()->after('email');
            }
            if (!Schema::hasColumn('pengurus', 'deskripsi')) {
                $table->text('deskripsi')->nullable()->after('telepon');
            }
        });
    }

    public function down(): void
    {
        Schema::table('pengurus', function (Blueprint $table) {
            $table->dropColumn(['email', 'telepon', 'deskripsi']);
        });
    }
};
