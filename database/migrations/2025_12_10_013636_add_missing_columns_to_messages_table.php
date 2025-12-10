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
        Schema::table('messages', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->after('id');
            $table->enum('sender_type', ['user', 'admin'])->after('user_id');
            $table->string('subject')->after('sender_type');
            $table->text('message')->after('subject');
            $table->enum('status', ['unread', 'read'])->default('unread')->after('message');
            $table->unsignedBigInteger('reply_to')->nullable()->after('status');
            
            // Foreign keys
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('reply_to')->references('id')->on('messages')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['reply_to']);
            $table->dropColumn(['user_id', 'sender_type', 'subject', 'message', 'status', 'reply_to']);
        });
    }
};
