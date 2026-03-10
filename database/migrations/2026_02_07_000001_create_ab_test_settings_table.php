<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ab_test_settings', function (Blueprint $table) {
            $table->id();
            $table->string('variant', 10)->unique(); // a, b, c
            $table->string('name'); // 표시 이름
            $table->string('description')->nullable(); // 설명
            $table->boolean('is_active')->default(true); // 활성화 여부
            $table->integer('traffic_percentage')->default(0); // 트래픽 비율 (0-100)
            $table->timestamps();
        });

        // 글로벌 설정 테이블
        Schema::create('ab_test_config', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ab_test_settings');
        Schema::dropIfExists('ab_test_config');
    }
};
