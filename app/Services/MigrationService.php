<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;

class MigrationService
{
    /**
     * 미실행 마이그레이션 개수 반환
     */
    public static function getPendingCount(): int
    {
        return count(self::getPendingMigrations());
    }

    /**
     * 미실행 마이그레이션 목록 반환
     */
    public static function getPendingMigrations(): array
    {
        $ran = self::getRanMigrations();
        $all = self::getAllMigrationFiles();

        return array_diff($all, $ran);
    }

    /**
     * 실행된 마이그레이션 목록 반환
     */
    public static function getRanMigrations(): array
    {
        try {
            return DB::table('migrations')->pluck('migration')->toArray();
        } catch (\Exception $e) {
            return [];
        }
    }

    /**
     * 모든 마이그레이션 파일 목록 반환
     */
    public static function getAllMigrationFiles(): array
    {
        $path = database_path('migrations');

        if (!File::isDirectory($path)) {
            return [];
        }

        $files = File::files($path);
        $migrations = [];

        foreach ($files as $file) {
            if ($file->getExtension() === 'php') {
                $migrations[] = pathinfo($file->getFilename(), PATHINFO_FILENAME);
            }
        }

        sort($migrations);
        return $migrations;
    }

    /**
     * 마이그레이션 상태 목록 반환
     */
    public static function getMigrationStatus(): array
    {
        $ran = self::getRanMigrations();
        $all = self::getAllMigrationFiles();
        $status = [];

        foreach ($all as $migration) {
            $status[] = [
                'name' => $migration,
                'ran' => in_array($migration, $ran),
                'batch' => self::getBatch($migration, $ran),
            ];
        }

        return $status;
    }

    /**
     * 마이그레이션 배치 번호 반환
     */
    private static function getBatch(string $migration, array $ran): ?int
    {
        if (!in_array($migration, $ran)) {
            return null;
        }

        try {
            return DB::table('migrations')
                ->where('migration', $migration)
                ->value('batch');
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * 마이그레이션 실행
     */
    public static function runMigrations(): array
    {
        try {
            Artisan::call('migrate', ['--force' => true]);
            $output = Artisan::output();

            return [
                'success' => true,
                'message' => '마이그레이션이 성공적으로 실행되었습니다.',
                'output' => $output,
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => '마이그레이션 실행 중 오류가 발생했습니다.',
                'output' => $e->getMessage(),
            ];
        }
    }

    /**
     * 마이그레이션 롤백
     */
    public static function rollbackMigration(): array
    {
        try {
            Artisan::call('migrate:rollback', ['--force' => true]);
            $output = Artisan::output();

            return [
                'success' => true,
                'message' => '마이그레이션이 롤백되었습니다.',
                'output' => $output,
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => '롤백 중 오류가 발생했습니다.',
                'output' => $e->getMessage(),
            ];
        }
    }
}
