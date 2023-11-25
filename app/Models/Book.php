<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    //this is setup relationship database
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
