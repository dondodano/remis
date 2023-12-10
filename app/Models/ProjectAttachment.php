<?php

namespace App\Models;

use App\Models\Project;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProjectAttachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'file_path',
        'project_id',
    ];

    // public function project(): BelongsTo
    // {
    //     return $this->belongsTo(Project::class, 'project_id', 'id');
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
