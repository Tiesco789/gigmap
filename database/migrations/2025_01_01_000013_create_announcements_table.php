<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->string('location')->nullable();
            $table->string('genre')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
        });

        // Add PostGIS geography column for spatial queries
        try {
            DB::statement('ALTER TABLE announcements ADD COLUMN coordinates geography(Point, 4326)');
        } catch (\Exception $e) {
            // PostGIS may not be available – continue without spatial column
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('announcements');
    }
};
