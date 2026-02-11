<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('post_requests', function (Blueprint $table) {
            $table->id();
            $table->string('token', 64)->unique();
            $table->string('customer_name')->nullable();
            $table->string('keyword')->nullable();
            $table->string('blog_url')->nullable();
            $table->string('published_url')->nullable();
            $table->string('status', 20)->default('requested'); // requested, in_progress, completed, as
            $table->unsignedBigInteger('contract_period_id')->nullable();
            $table->string('contract_month', 7)->nullable(); // YYYY-MM
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->index('status');
            $table->index('contract_period_id');
            $table->index('contract_month');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('post_requests');
    }
};
