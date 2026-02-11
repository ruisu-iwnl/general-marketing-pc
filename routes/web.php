<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\RecentLeadsController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LandingController::class, 'show']);

Route::post('/lead', [LeadController::class, 'store']);

Route::get('/thanks', function () {
    return view('thanks');
});

Route::get('/api/recent-leads', [RecentLeadsController::class, 'index']);

// API (인증 없음)
Route::get('/api/status', [ApiController::class, 'status']);
Route::get('/api/fake-leads', [ApiController::class, 'fakeLeads']);
Route::get('/api/all', [ApiController::class, 'all']);
Route::post('/api/cta-click', [ApiController::class, 'ctaClick']);

// 공개 페이지
Route::get('/public/view/{token}', [PublicController::class, 'view']);
Route::get('/public/period/{token}', [PublicController::class, 'period']);
Route::get('/public/per-post/{token}', [PublicController::class, 'perPostMonth']);
Route::get('/public/check-rank/{token}', [PublicController::class, 'checkRank']);

// cafe24 호스팅용 (document root가 public/ 폴더일 때)
Route::get('/view/{token}', [PublicController::class, 'view']);
Route::get('/period/{token}', [PublicController::class, 'period']);
Route::get('/per-post/{token}', [PublicController::class, 'perPostMonth']);
Route::get('/check-rank/{token}', [PublicController::class, 'checkRank']);

// Admin
Route::middleware('admin')->group(function () {
    Route::get('/admin/login', [AdminController::class, 'login'])->withoutMiddleware('admin');
    Route::post('/admin/login', [AdminController::class, 'loginSubmit'])->withoutMiddleware('admin');
    Route::get('/admin/logout', [AdminController::class, 'logout']);
    Route::get('/admin', [AdminController::class, 'index']);
    Route::get('/admin/leads', [AdminController::class, 'leads']);
    Route::get('/admin/leads/csv', [AdminController::class, 'exportCsv']);
    Route::get('/admin/leads/{id}', [AdminController::class, 'leadDetail']);
    Route::delete('/admin/leads/{id}', [AdminController::class, 'leadDelete']);
    Route::get('/admin/fake-settings', [AdminController::class, 'fakeSettings']);
    Route::post('/admin/fake-settings', [AdminController::class, 'fakeSettingsStore']);
    Route::put('/admin/fake-settings/{id}', [AdminController::class, 'fakeSettingsUpdate']);
    Route::post('/admin/fake-settings/{id}/toggle', [AdminController::class, 'fakeSettingsToggle']);
    Route::delete('/admin/fake-settings/{id}', [AdminController::class, 'fakeSettingsDelete']);
    Route::get('/admin/fake-leads', [AdminController::class, 'fakeLeads']);

    // 리드 CRM 기능
    Route::post('/admin/leads/{id}/status', [AdminController::class, 'leadUpdateStatus']);
    Route::post('/admin/leads/{id}/assign', [AdminController::class, 'leadAssign']);
    Route::post('/admin/leads/{id}/comment', [AdminController::class, 'leadAddComment']);
    Route::delete('/admin/leads/{leadId}/comment/{commentId}', [AdminController::class, 'leadDeleteComment']);

    // 매니저 관리
    Route::get('/admin/managers', [AdminController::class, 'managers']);
    Route::get('/admin/managers/create', [AdminController::class, 'managerCreate']);
    Route::post('/admin/managers', [AdminController::class, 'managerStore']);
    Route::get('/admin/managers/{id}/edit', [AdminController::class, 'managerEdit']);
    Route::put('/admin/managers/{id}', [AdminController::class, 'managerUpdate']);
    Route::delete('/admin/managers/{id}', [AdminController::class, 'managerDelete']);

    // API 엔드포인트 관리
    Route::get('/admin/settings/api', [AdminController::class, 'apiSettings']);
    Route::post('/admin/settings/api', [AdminController::class, 'apiSettingsStore']);
    Route::post('/admin/settings/api/trigger/{action}', [AdminController::class, 'apiTrigger']);

    // 설정
    Route::get('/admin/settings/migrations', [AdminController::class, 'migrations']);
    Route::post('/admin/settings/migrations/run', [AdminController::class, 'runMigrations']);
    Route::post('/admin/settings/migrations/rollback', [AdminController::class, 'rollbackMigration']);
    Route::get('/admin/settings/ab-test', [AdminController::class, 'abTestSettings']);
    Route::post('/admin/settings/ab-test', [AdminController::class, 'abTestSettingsStore']);
    Route::get('/admin/settings/telegram', [AdminController::class, 'telegramSettings']);
    Route::post('/admin/settings/telegram', [AdminController::class, 'telegramSettingsStore']);
    Route::post('/admin/settings/telegram/test', [AdminController::class, 'telegramTest']);

    // 방문자 통계
    Route::get('/admin/analytics', [AdminController::class, 'analytics']);
    Route::get('/admin/analytics/visitors', [AdminController::class, 'analyticsVisitors']);
    Route::get('/admin/analytics/api/chart', [AdminController::class, 'analyticsChartData']);

    // 로그인 이력
    Route::get('/admin/login-history', [AdminController::class, 'loginHistory']);
});

// Manager
Route::middleware('manager')->group(function () {
    Route::get('/manager/login', [ManagerController::class, 'login'])->withoutMiddleware('manager');
    Route::post('/manager/login', [ManagerController::class, 'loginSubmit'])->withoutMiddleware('manager');
    Route::get('/manager/logout', [ManagerController::class, 'logout']);
    Route::get('/manager', [ManagerController::class, 'index']);
    Route::get('/manager/leads', [ManagerController::class, 'leads']);
    Route::get('/manager/leads/{id}', [ManagerController::class, 'leadDetail']);
    Route::post('/manager/leads/{id}/status', [ManagerController::class, 'leadUpdateStatus']);
    Route::post('/manager/leads/{id}/comment', [ManagerController::class, 'leadAddComment']);
    Route::get('/manager/login-history', [ManagerController::class, 'myLoginHistory']);
});
