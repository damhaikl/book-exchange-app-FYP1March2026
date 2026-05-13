<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookSchedule extends Model
{
    protected $fillable = [
        'book_id',
        'seller_id',
        'buyer_id',
        'location',
        'meeting_date',
        'meeting_time',
        'status',
        'proposed_location',
        'proposed_date',
        'proposed_time'
    ];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }
}