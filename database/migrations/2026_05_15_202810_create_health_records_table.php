<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('health_records', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('family_member_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->decimal('height_cm', 6, 2)->nullable();
            $table->decimal('weight_kg', 6, 2)->nullable();
            $table->decimal('bmi', 6, 2)->nullable();

            $table->string('blood_pressure')->nullable();
            $table->decimal('sugar_level', 6, 2)->nullable();
            $table->integer('heart_rate')->nullable();
            $table->integer('oxygen_level')->nullable();

            $table->decimal('sleep_hours', 4, 2)->nullable();
            $table->integer('water_intake_ml')->nullable();

            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('health_records');
    }
};