<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;
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

    //this is a local query with dynamic value(dynamic scope)
    public function scopeTitle(Builder $query, string $title): Builder
    {
        return $query->where('title', 'LIKE', '%' . $title . '%');
    }

    public function scopePopular(Builder $query, $from = null, $to = null): Builder|QueryBuilder
    {
        return $query->withCount([
            'reviews' => fn (Builder $q) => $this->dateRangeFilter($q, $from, $to) //this using arrow function because $this will/can acces in outside class and access private method
        ])
            ->orderBy('reviews_count', 'desc'); //it will give alias column(new column with name reviews_count). it have rule name colomn before and add count from withCount
    }

    public function scopeHighestRated(Builder $query, $from = null, $to = null): Builder|QueryBuilder
    {
        return $query->withAvg([
            'reviews' => fn (Builder $q) => $this->dateRangeFilter($q, $from, $to) //this using arrow function because $this will/can acces in outside class and access private method
        ], 'rating')
            ->orderBy('reviews_avg_rating', 'desc');
    }

    public function scopeMinReviews(Builder $query, int $minReviews): Builder|QueryBuilder
    {
        return $query->having('reviews_count', '>=', $minReviews); //using having methods because aggregate function(withCount, withAvg)
    }

    //this is for filter by date
    private function dateRangeFilter(Builder $query, $from = null, $to = null)
    {
        if ($from && !$to) {
            $query->where('created_at', '>=', $from);
        } elseif (!$from && $to) {
            $query->where('created_at', '<=', $to);
        } elseif ($from && $to) {
            $query->whereBetween('created_at', [$from, $to]);
        }
    }
}
