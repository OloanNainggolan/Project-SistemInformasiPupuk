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
            // Add missing timestamp and processing fields
            $table->timestamp('confirmed_at')->nullable()->after('confirmed_by_user');
            $table->unsignedBigInteger('processed_by')->nullable()->after('confirmed_at');
            $table->timestamp('processed_at')->nullable()->after('processed_by');
            $table->timestamp('completed_at')->nullable()->after('processed_at');
            $table->text('admin_notes')->nullable()->after('rejection_reason');
            
            // Add indexes
            $table->index('processed_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropIndex(['processed_by']);
            $table->dropColumn([
                'confirmed_at',
                'processed_by',
                'processed_at',
                'completed_at',
                'admin_notes'
            ]);
        });
    }
};
