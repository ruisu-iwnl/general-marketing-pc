<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fake_lead_schedules', function (Blueprint $table) {
            $table->id();
            $table->time('time_start');
            $table->time('time_end');
            $table->unsignedInteger('min_interval_seconds')->default(120);
            $table->unsignedInteger('max_interval_seconds')->default(300);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fake_lead_schedules');
    }
};
