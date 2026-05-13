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
        'price',
        'meeting_location',
        'meeting_date',
        'meeting_time'
    ];

    // 👤 Seller (owner of book)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function schedule()
    {
        return $this->hasOne(BookSchedule::class);
    }
}