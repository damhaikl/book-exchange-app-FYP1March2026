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
        'listing_type',
        'price',
        'meeting_location',
        'meeting_date',
        'meeting_time',
        'meeting_end_time'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function schedule()
    {
        return $this->hasOne(BookSchedule::class);
    }

    // Exchange preferences for this listing
    public function exchangePreferences()
    {
        return $this->hasMany(BookExchangePreference::class);
    }

    // Requests where this book is requested
    public function requests()
    {
        return $this->hasMany(BookRequest::class);
    }

    // Requests where this book is offered
    public function offeredRequests()
    {
        return $this->hasMany(BookRequest::class, 'offered_book_id');
    }
}
