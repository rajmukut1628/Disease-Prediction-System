<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('symptom_checks', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('family_member_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->text('symptoms');
            $table->string('probable_disease')->nullable();

            $table->enum('severity', ['low', 'medium', 'high', 'emergency'])
                ->default('low');

            $table->unsignedTinyInteger('confidence_score')->default(0);

            $table->text('next_steps')->nullable();
            $table->text('ai_response')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('symptom_checks');
    }
};