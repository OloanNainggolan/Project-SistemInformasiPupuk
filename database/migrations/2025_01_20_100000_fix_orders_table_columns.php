<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Check if product_id column doesn't exist, rename id_produk to product_id
        if (Schema::hasColumn('orders', 'id_produk') && !Schema::hasColumn('orders', 'product_id')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->renameColumn('id_produk', 'product_id');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('orders', 'product_id') && !Schema::hasColumn('orders', 'id_produk')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->renameColumn('product_id', 'id_produk');
            });
        }
    }
};
