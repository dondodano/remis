<?php

namespace App\Models;

use App\Models\User;
use App\Observers\SpatieBackupObserver;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

#[ObservedBy([SpatieBackupObserver::class])]
class SpatieBackup extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'file_location',
        'file_name',
        'file_size'
    ];

    const DELETED_AT = 'deleted_at';
}
