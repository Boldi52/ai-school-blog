<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'author',
        'stance',
        'tags',
        'published_at',
    ];

    // tags-t automatikusan array-ként kezeljük
    protected $casts = [
        'tags' => 'array',
        'published_at' => 'datetime',
    ];
}