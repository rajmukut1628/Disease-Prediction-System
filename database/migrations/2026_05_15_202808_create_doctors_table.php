<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();

            $table->string('specialist');
            $table->string('degree')->nullable();
            $table->integer('experience')->default(0);
            $table->string('license_number')->nullable();

            $table->text('chamber_address')->nullable();
            $table->decimal('consultation_fee', 10, 2)->default(0);

            $table->enum('verification_status', ['pending', 'approved', 'rejected'])
                ->default('pending');

            $table->string('profile_photo')->nullable();
            $table->text('bio')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};