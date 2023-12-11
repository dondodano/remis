<?php

namespace App\Models;

use App\Models\Project;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProjectEvaluation extends Model
{
    use HasFactory,  SoftDeletes;

    protected $fillable = [
        'remarks',
        'remarks_status',
        'project_id',
        'user_id',
    ];

    const DELETED_AT = 'deleted_at';

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }
}
