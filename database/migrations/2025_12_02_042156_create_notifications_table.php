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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // 'contact', 'order', 'system'
            $table->string('title');
            $table->text('message');
            $table->string('link')->nullable(); // URL untuk detail
            $table->enum('status', ['unread', 'read'])->default('unread');
            $table->unsignedBigInteger('related_id')->nullable(); // ID terkait (contact_id, order_id, etc)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
