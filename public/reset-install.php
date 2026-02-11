<?php
/**
 * 설치 초기화 스크립트
 * 사용 후 반드시 삭제하세요!
 */

if (($_GET['token'] ?? '') !== 'reset2024') {
    die('Access denied. Use ?token=reset2024');
}

$lockFile = dirname(__DIR__) . '/storage/installed.lock';

echo "<h2>매일영 챌린지 설치 초기화</h2>";

if (file_exists($lockFile)) {
    if (unlink($lockFile)) {
        echo "<p style='color:green;'>installed.lock 파일이 삭제되었습니다.</p>";
        echo "<p><a href='/'>설치 페이지로 이동</a></p>";
    } else {
        echo "<p style='color:red;'>파일 삭제 실패. FTP에서 직접 삭제해주세요.</p>";
        echo "<p>경로: storage/installed.lock</p>";
    }
} else {
    echo "<p>installed.lock 파일이 이미 없습니다.</p>";
    echo "<p><a href='/'>설치 페이지로 이동</a></p>";
}

echo "<p style='color:red;'><strong>이 파일(reset-install.php)은 사용 후 반드시 삭제하세요!</strong></p>";
