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
        Schema::create('admin_activities', function (Blueprint $table) {
            $table->id();
            $table->string('action'); // e.g., 'login', 'update_profile', 'create_product', 'update_order_status'
            $table->string('description'); // Deskripsi aktivitas yang lebih detail
            $table->string('module')->nullable(); // Module/resource yang diakses: products, orders, users, profile
            $table->integer('related_id')->nullable(); // ID dari resource yang diakses
            $table->string('ip_address')->nullable(); // IP address admin
            $table->string('user_agent')->nullable(); // Browser/device info
            $table->text('changes')->nullable(); // JSON data perubahan (untuk audit trail)
            $table->enum('status', ['success', 'failed'])->default('success');
            $table->timestamps();
            
            // Index untuk query cepat
            $table->index('action');
            $table->index('module');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_activities');
    }
};
