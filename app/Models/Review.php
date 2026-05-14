<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Book;

class Review extends Model
{
    protected $fillable = [
        'book_id',
        'user_id',
        'rating',
        'comment',
    ];
    
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}