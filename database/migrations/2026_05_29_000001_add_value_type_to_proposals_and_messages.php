<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('proposals', function (Blueprint $table) {
            $table->decimal('value', 10, 2)->nullable()->after('message'); // null = "A negociar"
            $table->unsignedBigInteger('chat_id')->nullable()->after('value');
            $table->foreign('chat_id')->references('id')->on('chats')->nullOnDelete();
        });

        Schema::table('messages', function (Blueprint $table) {
            $table->string('type', 20)->default('text')->after('body'); // 'text' or 'proposal'
            $table->unsignedBigInteger('proposal_id')->nullable()->after('type');
            $table->foreign('proposal_id')->references('id')->on('proposals')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->dropForeign(['proposal_id']);
            $table->dropColumn(['type', 'proposal_id']);
        });

        Schema::table('proposals', function (Blueprint $table) {
            $table->dropForeign(['chat_id']);
            $table->dropColumn(['value', 'chat_id']);
        });
    }
};
