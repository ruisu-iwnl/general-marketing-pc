<?php

namespace App\Services;

use App\Models\Setting;
use Aws\S3\S3Client;
use Aws\Exception\AwsException;
use Illuminate\Support\Facades\Log;

class R2Storage
{
    private ?S3Client $client = null;
    private string $bucket;

    public function __construct()
    {
        $this->bucket = $this->getConfig('r2_bucket', env('R2_BUCKET', ''));
    }

    /**
     * S3 클라이언트 초기화
     */
    private function getClient(): ?S3Client
    {
        if ($this->client) {
            return $this->client;
        }

        $endpoint = $this->getConfig('r2_endpoint', env('R2_ENDPOINT', ''));
        $accessKey = $this->getConfig('r2_access_key', env('R2_ACCESS_KEY', ''));
        $secretKey = $this->getConfig('r2_secret_key', env('R2_SECRET_KEY', ''));
        $region = $this->getConfig('r2_region', env('R2_REGION', 'auto'));

        if (empty($endpoint) || empty($accessKey) || empty($secretKey)) {
            return null;
        }

        $options = [
            'region' => $region,
            'version' => 'latest',
            'endpoint' => $endpoint,
            'use_path_style_endpoint' => true,
            'credentials' => [
                'key' => $accessKey,
                'secret' => $secretKey,
            ],
        ];

        // 개발환경 SSL 검증 비활성화
        if (app()->environment('local', 'development')) {
            $options['http'] = [
                'verify' => false,
            ];
        }

        $this->client = new S3Client($options);

        return $this->client;
    }

    /**
     * 설정값 조회 (DB 우선, env fallback)
     */
    private function getConfig(string $key, string $default = ''): string
    {
        return Setting::getValue($key, $default) ?? $default;
    }

    /**
     * 파일 업로드
     */
    public function upload(string $localPath, string $key): bool
    {
        $client = $this->getClient();
        if (!$client || !file_exists($localPath)) {
            return false;
        }

        try {
            $client->putObject([
                'Bucket' => $this->bucket,
                'Key' => $key,
                'SourceFile' => $localPath,
                'ContentType' => mime_content_type($localPath) ?: 'application/octet-stream',
            ]);

            return true;
        } catch (AwsException $e) {
            Log::error('R2Storage upload failed', ['key' => $key, 'error' => $e->getMessage()]);
            return false;
        }
    }

    /**
     * 파일 다운로드
     */
    public function downloadToFile(string $key, string $localPath): bool
    {
        $client = $this->getClient();
        if (!$client) {
            return false;
        }

        try {
            $client->getObject([
                'Bucket' => $this->bucket,
                'Key' => $key,
                'SaveAs' => $localPath,
            ]);

            return true;
        } catch (AwsException $e) {
            Log::error('R2Storage download failed', ['key' => $key, 'error' => $e->getMessage()]);
            return false;
        }
    }

    /**
     * 파일 삭제
     */
    public function delete(string $key): bool
    {
        $client = $this->getClient();
        if (!$client) {
            return false;
        }

        try {
            $client->deleteObject([
                'Bucket' => $this->bucket,
                'Key' => $key,
            ]);

            return true;
        } catch (AwsException $e) {
            Log::error('R2Storage delete failed', ['key' => $key, 'error' => $e->getMessage()]);
            return false;
        }
    }

    /**
     * 파일 존재 확인
     */
    public function exists(string $key): bool
    {
        $client = $this->getClient();
        if (!$client) {
            return false;
        }

        try {
            $client->headObject([
                'Bucket' => $this->bucket,
                'Key' => $key,
            ]);

            return true;
        } catch (AwsException $e) {
            return false;
        }
    }

    /**
     * 오브젝트 목록 조회
     */
    public function listObjects(string $prefix = '', int $maxKeys = 1000): array
    {
        $client = $this->getClient();
        if (!$client) {
            return [];
        }

        try {
            $params = [
                'Bucket' => $this->bucket,
                'MaxKeys' => $maxKeys,
            ];

            if (!empty($prefix)) {
                $params['Prefix'] = $prefix;
            }

            $result = $client->listObjectsV2($params);

            return $result['Contents'] ?? [];
        } catch (AwsException $e) {
            Log::error('R2Storage listObjects failed', ['error' => $e->getMessage()]);
            return [];
        }
    }

    /**
     * 연결 테스트
     */
    public function testConnection(): array
    {
        $client = $this->getClient();
        if (!$client) {
            return ['success' => false, 'message' => 'R2 설정이 완료되지 않았습니다.'];
        }

        try {
            $client->listObjectsV2([
                'Bucket' => $this->bucket,
                'MaxKeys' => 1,
            ]);

            return ['success' => true, 'message' => '연결 성공'];
        } catch (AwsException $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * 설정 완료 여부
     */
    public function isConfigured(): bool
    {
        $endpoint = $this->getConfig('r2_endpoint', env('R2_ENDPOINT', ''));
        $accessKey = $this->getConfig('r2_access_key', env('R2_ACCESS_KEY', ''));
        $secretKey = $this->getConfig('r2_secret_key', env('R2_SECRET_KEY', ''));

        return !empty($endpoint) && !empty($accessKey) && !empty($secretKey) && !empty($this->bucket);
    }
}
