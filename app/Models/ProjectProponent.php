<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProjectProponent extends Model
{
    use HasFactory,  SoftDeletes;

    protected $fillable = [
        'first_name',
        'last_name',
        'avatar',
        'project_id',
        'proponent_type'
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
