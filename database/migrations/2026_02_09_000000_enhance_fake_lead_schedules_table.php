<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('fake_lead_schedules', function (Blueprint $table) {
            $table->string('name', 100)->nullable()->after('id');
            $table->unsignedInteger('daily_min_count')->nullable()->after('max_interval_seconds');
            $table->unsignedInteger('daily_max_count')->nullable()->after('daily_min_count');
            $table->json('time_distribution')->nullable()->after('daily_max_count');
            $table->json('days_of_week')->nullable()->after('time_distribution');
        });
    }

    public function down(): void
    {
        Schema::table('fake_lead_schedules', function (Blueprint $table) {
            $table->dropColumn(['name', 'daily_min_count', 'daily_max_count', 'time_distribution', 'days_of_week']);
        });
    }
};
