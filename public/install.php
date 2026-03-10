<?php
/**
 * DailyChallenge - Standalone Web Installer
 * Laravel 부팅 없이 독립 실행되는 설치 마법사
 */

$rootPath    = dirname(__DIR__);
$storagePath = $rootPath . '/storage';
$envPath     = $rootPath . '/.env';
$lockPath    = $storagePath . '/installed.lock';

// Already installed? Redirect to home
if (file_exists($lockPath)) {
    header('Location: /');
    exit;
}

/*
|--------------------------------------------------------------------------
| Handle AJAX POST requests
|--------------------------------------------------------------------------
*/
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json; charset=utf-8');

    $action = $_POST['action'] ?? '';

    // --- Test DB Connection ---
    if ($action === 'test') {
        $host = $_POST['db_host'] ?? 'localhost';
        $port = $_POST['db_port'] ?? '3306';
        $name = $_POST['db_name'] ?? '';
        $user = $_POST['db_user'] ?? '';
        $pass = $_POST['db_pass'] ?? '';

        try {
            $dsn = "mysql:host={$host};port={$port};dbname={$name};charset=utf8mb4";
            $pdo = new PDO($dsn, $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_TIMEOUT => 5,
            ]);
            echo json_encode(['success' => true, 'message' => 'DB 연결 성공']);
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => 'DB 연결 실패: ' . $e->getMessage()]);
        }
        exit;
    }

    // --- Create Tables ---
    if ($action === 'migrate') {
        $host = $_POST['db_host'] ?? 'localhost';
        $port = $_POST['db_port'] ?? '3306';
        $name = $_POST['db_name'] ?? '';
        $user = $_POST['db_user'] ?? '';
        $pass = $_POST['db_pass'] ?? '';

        try {
            $dsn = "mysql:host={$host};port={$port};dbname={$name};charset=utf8mb4";
            $pdo = new PDO($dsn, $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            ]);

            // users
            $pdo->exec("CREATE TABLE IF NOT EXISTS `users` (
                `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                `name` VARCHAR(255) NOT NULL,
                `email` VARCHAR(255) NOT NULL UNIQUE,
                `email_verified_at` TIMESTAMP NULL,
                `password` VARCHAR(255) NOT NULL,
                `remember_token` VARCHAR(100) NULL,
                `created_at` TIMESTAMP NULL,
                `updated_at` TIMESTAMP NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

            // password_reset_tokens
            $pdo->exec("CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
                `email` VARCHAR(255) PRIMARY KEY,
                `token` VARCHAR(255) NOT NULL,
                `created_at` TIMESTAMP NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

            // sessions
            $pdo->exec("CREATE TABLE IF NOT EXISTS `sessions` (
                `id` VARCHAR(255) PRIMARY KEY,
                `user_id` BIGINT UNSIGNED NULL,
                `ip_address` VARCHAR(45) NULL,
                `user_agent` TEXT NULL,
                `payload` LONGTEXT NOT NULL,
                `last_activity` INT NOT NULL,
                INDEX `sessions_user_id_index` (`user_id`),
                INDEX `sessions_last_activity_index` (`last_activity`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

            // cache
            $pdo->exec("CREATE TABLE IF NOT EXISTS `cache` (
                `key` VARCHAR(255) PRIMARY KEY,
                `value` MEDIUMTEXT NOT NULL,
                `expiration` INT NOT NULL,
                INDEX `cache_expiration_index` (`expiration`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

            // cache_locks
            $pdo->exec("CREATE TABLE IF NOT EXISTS `cache_locks` (
                `key` VARCHAR(255) PRIMARY KEY,
                `owner` VARCHAR(255) NOT NULL,
                `expiration` INT NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

            // jobs
            $pdo->exec("CREATE TABLE IF NOT EXISTS `jobs` (
                `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                `queue` VARCHAR(255) NOT NULL,
                `payload` LONGTEXT NOT NULL,
                `attempts` TINYINT UNSIGNED NOT NULL,
                `reserved_at` INT UNSIGNED NULL,
                `available_at` INT UNSIGNED NOT NULL,
                `created_at` INT UNSIGNED NOT NULL,
                INDEX `jobs_queue_index` (`queue`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

            // job_batches
            $pdo->exec("CREATE TABLE IF NOT EXISTS `job_batches` (
                `id` VARCHAR(255) PRIMARY KEY,
                `name` VARCHAR(255) NOT NULL,
                `total_jobs` INT NOT NULL,
                `pending_jobs` INT NOT NULL,
                `failed_jobs` INT NOT NULL,
                `failed_job_ids` LONGTEXT NOT NULL,
                `options` MEDIUMTEXT NULL,
                `cancelled_at` INT NULL,
                `created_at` INT NOT NULL,
                `finished_at` INT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

            // failed_jobs
            $pdo->exec("CREATE TABLE IF NOT EXISTS `failed_jobs` (
                `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                `uuid` VARCHAR(255) NOT NULL UNIQUE,
                `connection` TEXT NOT NULL,
                `queue` TEXT NOT NULL,
                `payload` LONGTEXT NOT NULL,
                `exception` LONGTEXT NOT NULL,
                `failed_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

            // leads
            $pdo->exec("CREATE TABLE IF NOT EXISTS `leads` (
                `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                `name` VARCHAR(255) NOT NULL,
                `phone` VARCHAR(255) NOT NULL,
                `utm_source` VARCHAR(255) NULL,
                `utm_medium` VARCHAR(255) NULL,
                `utm_campaign` VARCHAR(255) NULL,
                `referrer` VARCHAR(255) NULL,
                `created_at` TIMESTAMP NULL,
                `updated_at` TIMESTAMP NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

            // fake_lead_schedules
            $pdo->exec("CREATE TABLE IF NOT EXISTS `fake_lead_schedules` (
                `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                `time_start` TIME NOT NULL,
                `time_end` TIME NOT NULL,
                `min_interval_seconds` INT UNSIGNED NOT NULL DEFAULT 120,
                `max_interval_seconds` INT UNSIGNED NOT NULL DEFAULT 300,
                `is_active` TINYINT(1) NOT NULL DEFAULT 1,
                `created_at` TIMESTAMP NULL,
                `updated_at` TIMESTAMP NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

            // migrations (Laravel tracking)
            $pdo->exec("CREATE TABLE IF NOT EXISTS `migrations` (
                `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                `migration` VARCHAR(255) NOT NULL,
                `batch` INT NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

            // Record migrations as completed
            $pdo->exec("INSERT IGNORE INTO `migrations` (`migration`, `batch`) VALUES
                ('0001_01_01_000000_create_users_table', 1),
                ('0001_01_01_000001_create_cache_table', 1),
                ('0001_01_01_000002_create_jobs_table', 1),
                ('2025_01_01_000000_create_leads_table', 1),
                ('2025_01_02_000000_create_fake_lead_schedules_table', 1)
            ");

            echo json_encode(['success' => true, 'message' => '테이블 생성 완료']);
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => '테이블 생성 실패: ' . $e->getMessage()]);
        }
        exit;
    }

    // --- Complete Installation ---
    if ($action === 'complete') {
        $host = $_POST['db_host'] ?? 'localhost';
        $port = $_POST['db_port'] ?? '3306';
        $name = $_POST['db_name'] ?? '';
        $user = $_POST['db_user'] ?? '';
        $pass = $_POST['db_pass'] ?? '';

        try {
            // Generate APP_KEY
            $appKey = 'base64:' . base64_encode(random_bytes(32));

            // Detect APP_URL
            $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
            $appUrl = $scheme . '://' . ($_SERVER['HTTP_HOST'] ?? 'localhost');

            // Create .env
            $envContent = "APP_NAME=DailyChallenge
APP_ENV=production
APP_KEY={$appKey}
APP_DEBUG=false
APP_URL={$appUrl}

LOG_CHANNEL=single
LOG_LEVEL=error

DB_CONNECTION=mysql
DB_HOST={$host}
DB_PORT={$port}
DB_DATABASE={$name}
DB_USERNAME={$user}
DB_PASSWORD={$pass}

SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null

CACHE_STORE=database
QUEUE_CONNECTION=sync
FILESYSTEM_DISK=local
";

            file_put_contents($envPath, $envContent);

            // Create installed.lock
            file_put_contents($lockPath, date('Y-m-d H:i:s'));

            echo json_encode(['success' => true, 'message' => '설치 완료']);
        } catch (\Throwable $e) {
            echo json_encode(['success' => false, 'message' => '설치 실패: ' . $e->getMessage()]);
        }
        exit;
    }

    echo json_encode(['success' => false, 'message' => '알 수 없는 요청']);
    exit;
}

/*
|--------------------------------------------------------------------------
| Environment Checks
|--------------------------------------------------------------------------
*/
$checks = [];

// PHP version
$checks[] = [
    'label'   => 'PHP 버전 (8.2 이상)',
    'current' => PHP_VERSION,
    'passed'  => version_compare(PHP_VERSION, '8.2', '>='),
];

// Extensions
$exts = ['pdo_mysql', 'mbstring', 'openssl', 'tokenizer', 'ctype', 'json', 'curl', 'fileinfo'];
foreach ($exts as $ext) {
    $checks[] = [
        'label'  => $ext . ' 확장모듈',
        'passed' => extension_loaded($ext),
    ];
}

// Writable directories
$writableDirs = ['storage', 'storage/framework/cache', 'storage/framework/sessions', 'storage/framework/views', 'storage/logs'];
foreach ($writableDirs as $dir) {
    $fullPath = $rootPath . '/' . $dir;
    $checks[] = [
        'label'  => $dir . ' 쓰기 권한',
        'passed' => is_dir($fullPath) && is_writable($fullPath),
    ];
}

$allPassed = true;
foreach ($checks as $c) {
    if (!$c['passed']) { $allPassed = false; break; }
}

/*
|--------------------------------------------------------------------------
| Render Install Page
|--------------------------------------------------------------------------
*/
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>설치 | 매일영 챌린지</title>
    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
    <link href="https://cdn.jsdelivr.net/gh/orioncactus/pretendard@v1.3.9/dist/web/variable/pretendardvariable-dynamic-subset.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
    tailwind.config = {
        theme: { extend: { fontFamily: { sans: ['Pretendard','ui-sans-serif','system-ui','sans-serif'] } } }
    }
    </script>
    <style>
        .step-section { display: none; }
        .step-section.active { display: block; }
    </style>
</head>
<body class="font-sans bg-gray-50 min-h-screen flex items-center justify-center px-4 py-10">
<div class="w-full max-w-xl">

    <!-- Header -->
    <div class="text-center mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">매일영 챌린지 설치</h1>
        <p class="text-gray-500 text-sm" id="step-label">Step 1 / 2 &mdash; 환경 체크</p>
    </div>

    <!-- Progress -->
    <div class="flex items-center gap-2 mb-8 max-w-xs mx-auto">
        <div class="flex-1 h-2 rounded-full bg-blue-500" id="prog1"></div>
        <div class="flex-1 h-2 rounded-full bg-gray-200" id="prog2"></div>
    </div>

    <!-- ========== STEP 1: 환경 체크 ========== -->
    <div class="step-section active" id="section-step1">
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-100">
                <h2 class="font-semibold text-gray-800">서버 환경 점검</h2>
            </div>
            <div class="divide-y divide-gray-100">
                <?php foreach ($checks as $check): ?>
                <div class="flex items-center justify-between px-6 py-3.5">
                    <div class="flex items-center gap-3">
                        <?php if ($check['passed']): ?>
                        <div class="w-6 h-6 rounded-full bg-green-100 flex items-center justify-center">
                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        <?php else: ?>
                        <div class="w-6 h-6 rounded-full bg-red-100 flex items-center justify-center">
                            <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </div>
                        <?php endif; ?>
                        <span class="text-sm text-gray-700"><?= htmlspecialchars($check['label']) ?></span>
                    </div>
                    <?php if (isset($check['current'])): ?>
                    <span class="text-xs text-gray-400"><?= htmlspecialchars($check['current']) ?></span>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="mt-6 text-center">
            <?php if ($allPassed): ?>
            <button onclick="goStep2()" class="px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl transition shadow-lg shadow-blue-600/30 cursor-pointer">
                다음 단계로 &rarr;
            </button>
            <?php else: ?>
            <div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-4">
                <p class="text-red-700 text-sm font-medium">위 항목을 모두 통과해야 설치를 진행할 수 있습니다.</p>
            </div>
            <button onclick="location.reload()" class="px-8 py-3 bg-gray-400 text-white font-semibold rounded-xl cursor-pointer">다시 확인</button>
            <?php endif; ?>
        </div>
    </div>

    <!-- ========== STEP 2: DB 설정 + 완료 ========== -->
    <div class="step-section" id="section-step2">

        <!-- DB Form -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-100">
                <h2 class="font-semibold text-gray-800">데이터베이스 정보</h2>
                <p class="text-xs text-gray-400 mt-1">Cafe24 호스팅 패널 &gt; MySQL 관리에서 확인</p>
            </div>
            <div class="p-6 space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">호스트명</label>
                        <input type="text" id="db_host" value="localhost" class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">포트</label>
                        <input type="text" id="db_port" value="3306" class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">데이터베이스명</label>
                    <input type="text" id="db_name" class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Cafe24 DB명">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">사용자명</label>
                    <input type="text" id="db_user" class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Cafe24 DB 사용자명">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">비밀번호</label>
                    <input type="password" id="db_pass" class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Cafe24 DB 비밀번호">
                </div>

                <!-- Test -->
                <button type="button" id="btn-test" onclick="testConnection()" class="w-full py-2.5 bg-gray-700 hover:bg-gray-800 text-white font-medium rounded-lg transition text-sm cursor-pointer">
                    연결 테스트
                </button>
                <div id="msg-test" class="text-sm hidden"></div>
            </div>
        </div>

        <!-- Migration -->
        <div id="section-migrate" class="mt-6 bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden hidden">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-100">
                <h2 class="font-semibold text-gray-800">테이블 생성</h2>
            </div>
            <div class="p-6">
                <p class="text-sm text-gray-500 mb-4">DB 연결이 확인되었습니다. 필요한 테이블을 생성합니다.</p>
                <button type="button" id="btn-migrate" onclick="runMigration()" class="w-full py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition text-sm cursor-pointer">
                    테이블 생성
                </button>
                <div id="msg-migrate" class="mt-2 text-sm hidden"></div>
            </div>
        </div>

        <!-- Complete -->
        <div id="section-complete" class="mt-6 bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden hidden">
            <div class="p-6">
                <button type="button" id="btn-complete" onclick="completeInstall()" class="w-full py-3 bg-green-600 hover:bg-green-700 text-white font-bold rounded-lg transition text-sm cursor-pointer">
                    설치 완료
                </button>
                <div id="msg-complete" class="mt-2 text-sm hidden"></div>
            </div>
        </div>

        <!-- Back -->
        <div class="mt-6 text-center">
            <button onclick="goStep1()" class="text-sm text-gray-400 hover:text-gray-600 transition cursor-pointer">&larr; 이전 단계로</button>
        </div>
    </div>

    <p class="text-center text-gray-400 text-xs mt-8">&copy; <?= date('Y') ?> DailyChallenge</p>
</div>

<script>
function goStep2() {
    document.getElementById('section-step1').classList.remove('active');
    document.getElementById('section-step2').classList.add('active');
    document.getElementById('step-label').textContent = 'Step 2 / 2 — 데이터베이스 설정';
    document.getElementById('prog2').classList.replace('bg-gray-200','bg-blue-500');
}
function goStep1() {
    document.getElementById('section-step2').classList.remove('active');
    document.getElementById('section-step1').classList.add('active');
    document.getElementById('step-label').textContent = 'Step 1 / 2 — 환경 체크';
    document.getElementById('prog2').classList.replace('bg-blue-500','bg-gray-200');
}

function getDbData() {
    return new URLSearchParams({
        db_host: document.getElementById('db_host').value,
        db_port: document.getElementById('db_port').value,
        db_name: document.getElementById('db_name').value,
        db_user: document.getElementById('db_user').value,
        db_pass: document.getElementById('db_pass').value,
    });
}

function showMsg(id, ok, text) {
    const el = document.getElementById(id);
    el.className = 'mt-2 text-sm ' + (ok ? 'text-green-600' : 'text-red-600');
    el.textContent = text;
}

function setLoading(id, on) {
    const btn = document.getElementById(id);
    if (on) { btn._txt = btn.textContent; btn.textContent = '처리 중...'; btn.disabled = true; btn.classList.add('opacity-60'); }
    else { btn.textContent = btn._txt || ''; btn.disabled = false; btn.classList.remove('opacity-60'); }
}

async function testConnection() {
    setLoading('btn-test', true);
    try {
        const body = getDbData(); body.append('action','test');
        const res = await fetch('', { method:'POST', body });
        const json = await res.json();
        showMsg('msg-test', json.success, json.message);
        if (json.success) document.getElementById('section-migrate').classList.remove('hidden');
    } catch(e) { showMsg('msg-test', false, '요청 실패: '+e.message); }
    finally { setLoading('btn-test', false); }
}

async function runMigration() {
    setLoading('btn-migrate', true);
    try {
        const body = getDbData(); body.append('action','migrate');
        const res = await fetch('', { method:'POST', body });
        const json = await res.json();
        showMsg('msg-migrate', json.success, json.message);
        if (json.success) document.getElementById('section-complete').classList.remove('hidden');
    } catch(e) { showMsg('msg-migrate', false, '요청 실패: '+e.message); }
    finally { setLoading('btn-migrate', false); }
}

async function completeInstall() {
    setLoading('btn-complete', true);
    try {
        const body = getDbData(); body.append('action','complete');
        const res = await fetch('', { method:'POST', body });
        const json = await res.json();
        showMsg('msg-complete', json.success, json.message);
        if (json.success) {
            document.getElementById('btn-complete').textContent = '설치 완료! 이동 중...';
            setTimeout(() => { window.location.href = '/'; }, 1500);
        }
    } catch(e) { showMsg('msg-complete', false, '요청 실패: '+e.message); }
    finally { setLoading('btn-complete', false); }
}
</script>
</body>
</html>
