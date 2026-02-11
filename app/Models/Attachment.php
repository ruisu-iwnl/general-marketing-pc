<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Attachment extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'post_request_id', 'original_name', 'stored_name',
        'file_path', 'file_size', 'storage_type', 'created_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function postRequest()
    {
        return $this->belongsTo(PostRequest::class);
    }

    /**
     * 삭제 대상 첨부파일 조회
     */
    public static function getOldAttachments(int $days)
    {
        $cutoff = now()->subDays($days);

        return static::join('post_requests', 'attachments.post_request_id', '=', 'post_requests.id')
            ->whereIn('post_requests.status', ['completed', 'as'])
            ->whereNotNull('post_requests.completed_at')
            ->where('post_requests.completed_at', '<', $cutoff)
            ->select('attachments.*')
            ->get();
    }

    /**
     * 의뢰별 첨부파일 목록
     */
    public static function getByPostRequestId(int $postRequestId)
    {
        return static::where('post_request_id', $postRequestId)
            ->orderBy('created_at', 'asc')
            ->get();
    }

    /**
     * 전체 통계
     */
    public static function getTotalStats(): array
    {
        $stats = static::selectRaw('COUNT(*) as total_count, COALESCE(SUM(file_size), 0) as total_size')
            ->first();

        return [
            'total_count' => (int) $stats->total_count,
            'total_size' => (int) $stats->total_size,
        ];
    }

    /**
     * 스토리지 타입별 통계
     */
    public static function getStatsByStorageType(): array
    {
        return static::selectRaw('storage_type, COUNT(*) as count, COALESCE(SUM(file_size), 0) as size')
            ->groupBy('storage_type')
            ->get()
            ->keyBy('storage_type')
            ->toArray();
    }
}
