<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    public const SUBJECT_CATEGORIES = [
        'Elective Subject',
        'Common Core Subject',
        'University Compulsory Subject',
        'Final Year Project',
        'MPU Subject',
    ];

    protected $fillable = [
        'title',
        'description',
        'condition',
        'subject_id',
        'subject_category',
        'image',
        'user_id',
        'status',
        'price',
        'meeting_location',
        'meeting_date',
        'meeting_time',
        'meeting_end_time'
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
