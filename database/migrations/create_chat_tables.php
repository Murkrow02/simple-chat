<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Create table for storing chats (can be private or group)
        Schema::create('chat', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->boolean('group')->default(false);
            $table->timestamps();
        });

        // Create table for associating conversations to users (Many-to-Many)
        Schema::create('user_chats_pivot', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chat_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        // Create table for storing messages
        Schema::create('chat_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chat_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('body');
            $table->timestamps();
        });
    }
};
