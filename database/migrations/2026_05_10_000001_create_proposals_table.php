<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('proposals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('announcement_id')->constrained()->onDelete('cascade');
            $table->foreignId('sender_id')->constrained('users')->onDelete('cascade');
            $table->text('message')->nullable();
            $table->string('status')->default('pending'); // pending, accepted, rejected
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('proposals');
    }
};
