<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('risk_predictions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('family_member_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->unsignedTinyInteger('diabetes_risk')->default(0);
            $table->unsignedTinyInteger('heart_disease_risk')->default(0);
            $table->unsignedTinyInteger('kidney_disease_risk')->default(0);
            $table->unsignedTinyInteger('stroke_risk')->default(0);

            $table->enum('overall_risk_level', ['low', 'medium', 'high', 'critical'])
                ->default('low');

            $table->json('input_data')->nullable();
            $table->text('recommendation')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('risk_predictions');
    }
};