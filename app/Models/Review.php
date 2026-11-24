<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'book_id',
        'book_request_id',
        'user_id',
        'reviewed_user_id',
        'rating',
        'comment',
    ];

    // The book being reviewed
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    // The student who submitted the review
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // The student who received the review
    public function reviewedUser()
    {
        return $this->belongsTo(User::class, 'reviewed_user_id');
    }
}
