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
    Schema::create('anak_asuh', function (Blueprint $table) {
        $table->string('niap', 15)->primary();
        $table->string('nama', 100);
        $table->enum('jenis_kelamin', ['L','P']);
        $table->string('tempat_lahir', 50)->nullable();
        $table->date('tanggal_lahir')->nullable();
        $table->date('tanggal_masuk');
        $table->text('alamat_asal')->nullable();
        $table->enum('status', ['aktif','keluar','adopsi'])->default('aktif');
        $table->string('tingkat_pendidikan', 30)->nullable();
        $table->string('nama_sekolah', 100)->nullable();
        $table->string('foto')->nullable();
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anak_asuh');
    }
};
