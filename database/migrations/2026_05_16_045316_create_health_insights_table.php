<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('health_insights', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('family_member_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->string('title')->nullable();

            $table->enum('trend_status', [
                'improving',
                'stable',
                'worsening',
                'critical',
                'unknown'
            ])->default('unknown');

            $table->unsignedTinyInteger('confidence_score')->default(0);

            $table->longText('health_summary')->nullable();
            $table->longText('risk_warning')->nullable();
            $table->longText('next_action_plan')->nullable();

            $table->json('key_changes')->nullable();
            $table->json('ai_raw_response')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('health_insights');
    }
};