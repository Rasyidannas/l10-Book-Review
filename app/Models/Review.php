<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = ['review', 'rating'];

    //this is setup relationship database
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    protected static function booted(): void
    {
        //this is for event model for updated (when review model updated function will excute)
        static::updated(fn (Review $review) => cache()->forget('book:' . $review->book_id));
        //this is for event model for deleted (when review model deleted function will excute)
        static::deleted(fn (Review $review) => cache()->forget('book:' . $review->book_id));
    }
}
