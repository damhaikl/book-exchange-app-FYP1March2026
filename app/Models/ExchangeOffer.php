<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExchangeOffer extends Model
{
    protected $fillable = [
        'book_request_id',
        'offered_book_id',
        'title',
        'subject_id',
        'condition',
        'image',
    ];

    public function bookRequest()
    {
        return $this->belongsTo(BookRequest::class);
    }

    public function offeredBook()
    {
        return $this->belongsTo(Book::class, 'offered_book_id');
    }
}
