<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookExchangePreference extends Model
{
    protected $fillable = [
        'book_id',
        'wanted_subject_id',
        'wanted_book_name',
    ];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
