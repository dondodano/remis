<?php

namespace App\Models;

use App\Enums\FundCategory;
use App\Enums\ProjectStatus;
use App\Enums\ProjectCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory,  SoftDeletes;

    protected $fillable = [
        'title',
        'budget',
        'attachments',
        'start_at',
        'end_at',
        'project_category',
        'fund_category',
        'project_status'
    ];

    protected $casts = [
        'attachments' => 'array',
        'project_category' => ProjectCategory::class,
        'fund_category' => FundCategory::class,
        'project_status' => ProjectStatus::class
    ];

    const DELETED_AT = 'deleted_at';

    /**
     * Override boot
     */
    public static function boot()
    {
        parent::boot();

        static::created(function($user){

        });

        static::updated(function($user){

        });

        static::deleted(function($user){

        });
    }
}
