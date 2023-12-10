<?php

namespace App\Models;

use App\Enums\FundCategory;
use App\Enums\ProjectStatus;
use App\Enums\ProjectCategory;
use App\Models\ProjectAttachment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
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

    public function members(): HasMany
    {
        return $this->hasMany(ProjectMember::class, 'project_id', 'id');
    }

    // public function documents(): HasMany
    // {
    //     return $this->hasMany(ProjectAttachment::class,'project_id', 'id');
    // }

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
