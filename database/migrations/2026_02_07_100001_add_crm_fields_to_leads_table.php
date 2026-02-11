<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->foreignId('manager_id')->nullable()->constrained('managers')->nullOnDelete();
            $table->string('status')->default('new'); // new, contacted, consulting, converted, lost
            $table->timestamp('contacted_at')->nullable();
            $table->timestamp('converted_at')->nullable();
            $table->text('note')->nullable(); // 간단한 메모
        });
    }

    public function down(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->dropForeign(['manager_id']);
            $table->dropColumn(['manager_id', 'status', 'contacted_at', 'converted_at', 'note']);
        });
    }
};
