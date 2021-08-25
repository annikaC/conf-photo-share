<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected static function booted() {
        static::creating(function ($photo) {
            if ($photo->tags === null) {
                // if tags are not provided on creation
                $photo->tags = "[]";  // set empty json array
            }
        });
    }
    /**
     * @var string[]
     */
    protected $fillable = [
        's3_path',
        'author',
        'size',
        'mime',
        'tags'
    ];
}
