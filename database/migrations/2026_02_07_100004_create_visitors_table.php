<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 방문자 (유니크 방문자)
        Schema::create('visitors', function (Blueprint $table) {
            $table->id();
            $table->string('visitor_hash', 64)->unique(); // 쿠키 기반 식별자
            $table->string('ip_address', 45)->nullable();
            $table->string('country', 2)->nullable(); // ISO 국가 코드
            $table->string('city', 100)->nullable();
            $table->timestamp('first_visit_at')->nullable();
            $table->timestamp('last_visit_at')->nullable();
            $table->unsignedInteger('total_visits')->default(1);
            $table->unsignedInteger('total_pageviews')->default(0);
            $table->boolean('is_converted')->default(false); // 리드로 전환 여부
            $table->foreignId('lead_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();

            $table->index('ip_address');
            $table->index('first_visit_at');
            $table->index('is_converted');
        });

        // 페이지뷰
        Schema::create('page_views', function (Blueprint $table) {
            $table->id();
            $table->foreignId('visitor_id')->constrained()->cascadeOnDelete();
            $table->string('session_id', 64);
            $table->string('url', 500);
            $table->string('page_title', 255)->nullable();

            // 유입 정보
            $table->string('referrer', 500)->nullable();
            $table->string('referrer_domain', 255)->nullable();
            $table->string('utm_source', 100)->nullable();
            $table->string('utm_medium', 100)->nullable();
            $table->string('utm_campaign', 100)->nullable();
            $table->string('utm_term', 100)->nullable();
            $table->string('utm_content', 100)->nullable();

            // 디바이스 정보
            $table->string('device_type', 20)->nullable(); // desktop, mobile, tablet
            $table->string('os', 50)->nullable();
            $table->string('os_version', 20)->nullable();
            $table->string('browser', 50)->nullable();
            $table->string('browser_version', 20)->nullable();
            $table->unsignedSmallInteger('screen_width')->nullable();
            $table->unsignedSmallInteger('screen_height')->nullable();

            // A/B 테스트
            $table->string('variant', 10)->nullable();

            $table->timestamp('created_at')->useCurrent();

            $table->index('session_id');
            $table->index('created_at');
            $table->index('utm_source');
            $table->index('device_type');
            $table->index('referrer_domain');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('page_views');
        Schema::dropIfExists('visitors');
    }
};
