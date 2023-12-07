<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory,  SoftDeletes;

    protected $fillable = [
        'title',
        'budget',
        'start_at',
        'end_at',
        'project_category',
        'fund_category',
        'project_status'
    ];

    protected $casts = [
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
