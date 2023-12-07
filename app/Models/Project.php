<?php

namespace App\Models;

<<<<<<< HEAD
=======
use App\Enums\FundCategory;
use App\Enums\ProjectStatus;
use App\Enums\ProjectCategory;
use App\Models\ProjectAttachment;
>>>>>>> 48871c4 (REMIS update on 12-07-2023)
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory,  SoftDeletes;

    protected $fillable = [
        'title',
        'budget',
<<<<<<< HEAD
=======
        'attachments',
>>>>>>> 48871c4 (REMIS update on 12-07-2023)
        'start_at',
        'end_at',
        'project_category',
        'fund_category',
        'project_status'
    ];

    protected $casts = [
<<<<<<< HEAD
=======
        'attachments' => 'array',
        'start_at' => 'datetime',
        'end_at' => 'datetime',
>>>>>>> 48871c4 (REMIS update on 12-07-2023)
        'project_category' => ProjectCategory::class,
        'fund_category' => FundCategory::class,
        'project_status' => ProjectStatus::class
    ];

    const DELETED_AT = 'deleted_at';

<<<<<<< HEAD
=======
    public function project_attachments()
    {
        return $this->hasMany(ProjectAttachment::class, 'project_id', 'id');
    }


>>>>>>> 48871c4 (REMIS update on 12-07-2023)
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
