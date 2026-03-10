<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cta_clicks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('visitor_id')->constrained('visitors')->cascadeOnDelete();
            $table->string('variant', 1);
            $table->string('button_type', 50)->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->unique(['visitor_id', 'variant']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cta_clicks');
    }
};
