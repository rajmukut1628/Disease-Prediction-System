<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('medical_reports', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('family_member_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->enum('report_type', [
                'blood_test',
                'ecg',
                'xray',
                'urine_test',
                'prescription',
                'other'
            ])->default('other');

            $table->string('title');
            $table->string('file_path');
            $table->string('original_name')->nullable();
            $table->string('mime_type')->nullable();
            $table->unsignedBigInteger('file_size')->nullable();

            $table->text('ai_summary')->nullable();
            $table->text('warning_signs')->nullable();

            $table->boolean('is_encrypted')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medical_reports');
    }
};