<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attachments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('post_request_id');
            $table->string('original_name');
            $table->string('stored_name');
            $table->string('file_path');
            $table->unsignedBigInteger('file_size')->default(0);
            $table->string('storage_type', 20)->default('local'); // local, r2
            $table->timestamp('created_at')->nullable();

            $table->foreign('post_request_id')->references('id')->on('post_requests')->onDelete('cascade');
            $table->index('post_request_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attachments');
    }
};
