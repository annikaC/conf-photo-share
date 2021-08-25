<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = [
        's3_path',
        'author',
        'size',
        'mime'
    ];
}
