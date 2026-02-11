<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AbTestSetting extends Model
{
    protected $fillable = [
        'variant',
        'name',
        'description',
        'is_active',
        'traffic_percentage',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'traffic_percentage' => 'integer',
    ];
}
