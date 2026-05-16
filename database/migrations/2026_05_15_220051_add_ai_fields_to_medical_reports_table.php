<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('medical_reports', function (Blueprint $table) {
            if (!Schema::hasColumn('medical_reports', 'ai_confidence_score')) {
                $table->unsignedTinyInteger('ai_confidence_score')->default(0)->after('warning_signs');
            }

            if (!Schema::hasColumn('medical_reports', 'recommended_specialist')) {
                $table->string('recommended_specialist')->nullable()->after('ai_confidence_score');
            }

            if (!Schema::hasColumn('medical_reports', 'severity_level')) {
                $table->enum('severity_level', ['low', 'medium', 'high', 'emergency'])
                    ->default('low')
                    ->after('recommended_specialist');
            }

            if (!Schema::hasColumn('medical_reports', 'abnormal_findings')) {
                $table->json('abnormal_findings')->nullable()->after('severity_level');
            }

            if (!Schema::hasColumn('medical_reports', 'health_advice')) {
                $table->text('health_advice')->nullable()->after('abnormal_findings');
            }

            if (!Schema::hasColumn('medical_reports', 'ai_raw_response')) {
                $table->longText('ai_raw_response')->nullable()->after('health_advice');
            }
        });
    }

    public function down(): void
    {
        Schema::table('medical_reports', function (Blueprint $table) {
            foreach ([
                'ai_confidence_score',
                'recommended_specialist',
                'severity_level',
                'abnormal_findings',
                'health_advice',
                'ai_raw_response',
            ] as $column) {
                if (Schema::hasColumn('medical_reports', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};