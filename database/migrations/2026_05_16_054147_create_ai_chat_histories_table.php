<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ai_chat_histories', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('family_member_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->longText('user_message');
            $table->longText('ai_response')->nullable();

            $table->string('language')->default('auto');
            $table->unsignedTinyInteger('confidence_score')->default(0);

            $table->json('meta')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ai_chat_histories');
    }
};