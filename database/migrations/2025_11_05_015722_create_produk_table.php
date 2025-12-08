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
        Schema::create('produk', function (Blueprint $table) {
            $table->integer('id_produk', true);
            $table->string('nama_produk');
            $table->enum('tipe_produk', ['pupuk', 'bibit']);
            $table->string('kategori');
            $table->decimal('harga_subsidi', 10, 2);
            $table->decimal('harga_normal', 10, 2);
            $table->integer('stok_produk');
            $table->string('gambar');
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk');
    }
};
