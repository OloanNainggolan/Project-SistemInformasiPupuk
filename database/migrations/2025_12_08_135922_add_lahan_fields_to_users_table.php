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
        Schema::table('users', function (Blueprint $table) {
            $table->decimal('luas_lahan', 10, 2)->nullable()->after('kode_pos')->comment('Luas lahan dalam hektar');
            $table->string('jenis_tanaman')->nullable()->after('luas_lahan')->comment('Jenis tanaman yang ditanam');
            $table->string('lokasi_lahan')->nullable()->after('jenis_tanaman')->comment('Lokasi/alamat lahan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['luas_lahan', 'jenis_tanaman', 'lokasi_lahan']);
        });
    }
};
