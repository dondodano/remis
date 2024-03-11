<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SpatieBackup extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'file_location',
        'file_name',
        'file_size'
    ];
}
