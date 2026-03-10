<?php
/**
 * Cafe24 Debug Script
 * 문제 진단용 - 확인 후 삭제하세요
 */

// 보안: 토큰 확인
if (($_GET['token'] ?? '') !== 'debug2024') {
    die('Access denied. Use ?token=debug2024');
}

echo "<h2>Cafe24 Debug Info</h2>";
echo "<pre>";

// 1. PHP 버전
echo "PHP Version: " . PHP_VERSION . "\n\n";

// 2. 현재 경로
echo "Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "\n";
echo "Script Filename: " . $_SERVER['SCRIPT_FILENAME'] . "\n";
echo "Current Dir: " . __DIR__ . "\n\n";

// 3. 중요 파일 존재 확인
$rootPath = dirname(__DIR__);
$files = [
    'vendor/autoload.php',
    'bootstrap/app.php',
    'storage/installed.lock',
    '.env',
    '.htaccess',
    'public/.htaccess',
];

echo "=== File Check ===\n";
foreach ($files as $file) {
    $fullPath = $rootPath . '/' . $file;
    $exists = file_exists($fullPath) ? 'OK' : 'MISSING';
    $readable = is_readable($fullPath) ? 'readable' : 'not readable';
    echo "{$file}: {$exists} ({$readable})\n";
}

// 4. 폴더 권한 확인
echo "\n=== Directory Permissions ===\n";
$dirs = [
    '',
    'public',
    'storage',
    'storage/logs',
    'storage/framework',
    'storage/framework/cache',
    'storage/framework/sessions',
    'storage/framework/views',
    'bootstrap/cache',
];

foreach ($dirs as $dir) {
    $fullPath = $rootPath . '/' . $dir;
    if (is_dir($fullPath)) {
        $perms = substr(sprintf('%o', fileperms($fullPath)), -4);
        $writable = is_writable($fullPath) ? 'writable' : 'not writable';
        echo "{$dir}: {$perms} ({$writable})\n";
    } else {
        echo "{$dir}: NOT FOUND\n";
    }
}

// 5. .env 파일 내용 (민감정보 마스킹)
echo "\n=== .env Check ===\n";
$envPath = $rootPath . '/.env';
if (file_exists($envPath)) {
    $envContent = file_get_contents($envPath);
    $lines = explode("\n", $envContent);
    foreach ($lines as $line) {
        if (strpos($line, 'PASSWORD') !== false || strpos($line, 'KEY') !== false) {
            $parts = explode('=', $line, 2);
            echo $parts[0] . "=***HIDDEN***\n";
        } else {
            echo $line . "\n";
        }
    }
} else {
    echo ".env file not found!\n";
}

// 6. 에러 로그 최근 내용
echo "\n=== Recent Error Log ===\n";
$logPath = $rootPath . '/storage/logs/laravel.log';
if (file_exists($logPath)) {
    $log = file_get_contents($logPath);
    $lines = explode("\n", $log);
    $recentLines = array_slice($lines, -30);
    echo implode("\n", $recentLines);
} else {
    echo "No log file found.\n";
}

echo "</pre>";
echo "<p style='color:red;'><strong>이 파일(debug.php)은 확인 후 반드시 삭제하세요!</strong></p>";
