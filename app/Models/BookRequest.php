<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookRequest extends Model
{
    protected $fillable = [
        'book_id',
        'requester_id',
        'owner_id',
        'status',

        // 🧠 SMART MEETING
        'proposed_location',
        'proposed_date',
        'proposed_time',
        'schedule_type'
    ];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function requester()
    {
        return $this->belongsTo(User::class, 'requester_id');
    }
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }
}
