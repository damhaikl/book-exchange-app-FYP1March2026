<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'title',
        'description',
        'condition',
        'subject_id',
        'image',
        'user_id',
        'status',
        'price'
    ];
}