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
        Schema::table('orders', function (Blueprint $table) {
            // Product information
            $table->integer('product_id')->nullable()->after('user_id');
            $table->integer('quantity')->default(1)->after('product_id');
            $table->decimal('unit_price', 15, 2)->default(0)->after('quantity');
            $table->decimal('subtotal', 15, 2)->default(0)->after('unit_price');
            
            // Discount information
            $table->decimal('discount_amount', 15, 2)->default(0)->after('subtotal');
            $table->unsignedBigInteger('discount_id')->nullable()->after('discount_amount');
            
            // Customer information
            $table->string('customer_name')->nullable()->after('village_office');
            $table->string('customer_phone', 20)->nullable()->after('customer_name');
            $table->text('customer_address')->nullable()->after('customer_phone');
            $table->text('customer_notes')->nullable()->after('customer_address');
            
            // Confirmation timestamp
            $table->timestamp('confirmed_at')->nullable()->after('confirmed_by_user');
            
            // Foreign key for product
            $table->foreign('product_id')->references('id_produk')->on('produk')->onDelete('set null');
            
            // Foreign key for discount (if discount table exists)
            // Uncomment if you have discounts table
            // $table->foreign('discount_id')->references('id')->on('discounts')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Drop foreign keys first
            $table->dropForeign(['product_id']);
            // $table->dropForeign(['discount_id']);
            
            // Drop columns
            $table->dropColumn([
                'product_id',
                'quantity',
                'unit_price',
                'subtotal',
                'discount_amount',
                'discount_id',
                'customer_name',
                'customer_phone',
                'customer_address',
                'customer_notes',
                'confirmed_at',
            ]);
        });
    }
};
