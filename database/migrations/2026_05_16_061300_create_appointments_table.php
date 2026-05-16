<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('doctor_id')
                ->constrained('doctors')
                ->cascadeOnDelete();

            $table->date('appointment_date');
            $table->time('appointment_time');

            $table->string('patient_name')->nullable();
            $table->string('patient_phone')->nullable();

            $table->text('problem_description')->nullable();

            $table->enum('status', [
                'pending',
                'approved',
                'rejected',
                'completed'
            ])->default('pending');

            $table->text('doctor_note')->nullable();
            $table->text('reject_reason')->nullable();

            $table->timestamps();

            $table->unique([
                'doctor_id',
                'appointment_date',
                'appointment_time'
            ], 'doctor_appointment_unique_slot');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};