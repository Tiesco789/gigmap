<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chats', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('musician_id');
            $table->unsignedBigInteger('establishment_id');
            $table->timestamp('last_message_at')->nullable();
            $table->timestamps();

            $table->foreign('musician_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('establishment_id')->references('id')->on('users')->cascadeOnDelete();

            // Garante 1 chat único por par músico↔estabelecimento
            $table->unique(['musician_id', 'establishment_id']);

            $table->index('last_message_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chats');
    }
};
