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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // ID user pengirim/penerima
            $table->enum('sender_type', ['user', 'admin']); // Siapa yang mengirim
            $table->string('subject'); // Subjek pesan
            $table->text('message'); // Isi pesan
            $table->enum('status', ['unread', 'read'])->default('unread'); // Status baca
            $table->unsignedBigInteger('reply_to')->nullable(); // ID pesan yang dibalas
            $table->timestamps();
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('reply_to')->references('id')->on('messages')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
