<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('barang', function (Blueprint $table) {
            $table->id();
            
            $table->string('kode_barang', 20)->unique();
            $table->string('nama_barang', 150);
            $table->string('satuan', 50);
            $table->enum('kategori', ['baku', 'tidak_baku']);
            
           
            $table->unsignedInteger('stok_saat_ini')->default(0)
                  ->comment('Stok master - diupdate otomatis via event/model');
            
            $table->text('keterangan')->nullable();
            
            $table->timestamps();

            $table->index('kode_barang');
            $table->index('nama_barang');
            $table->index('kategori');
        });

        
    }

    public function down(): void
    {
        Schema::dropIfExists('barang');
    }
};