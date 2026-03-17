<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('establishment_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('establishment_name')->nullable();
            $table->string('cnpj')->nullable();
            $table->string('website')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('cep')->nullable();
            $table->string('address')->nullable();
            $table->text('about')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('establishment_profiles');
    }
};
