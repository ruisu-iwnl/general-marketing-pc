<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rank_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('post_request_id');
            $table->string('check_type', 50)->nullable();
            $table->timestamp('scheduled_at')->nullable();
            $table->timestamp('checked_at')->nullable();
            $table->unsignedInteger('rank')->nullable();
            $table->unsignedInteger('retry_count')->default(0);
            $table->string('status', 20)->default('pending'); // pending, completed, failed
            $table->timestamps();

            $table->foreign('post_request_id')->references('id')->on('post_requests')->onDelete('cascade');
            $table->index(['status', 'scheduled_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rank_records');
    }
};
