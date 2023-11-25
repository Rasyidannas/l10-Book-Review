<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Book;
use App\Models\Review;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Book::factory(33)->create()->each(function ($book) {
            $numReviews = random_int(5, 30);

            //this is wil create random data for Review with good
            Review::factory()->count($numReviews)
                ->good() //this is call state or custom function value
                ->for($book) //this is for belongs to (review is child of book in database)
                ->create();
        });

        Book::factory(33)->create()->each(function ($book) {
            $numReviews = random_int(5, 30);

            //this is wil create random data for Review with average
            Review::factory()->count($numReviews)
                ->average() //this is call state or custom function value
                ->for($book) //this is for belongs to (review is child of book in database)
                ->create();
        });

        Book::factory(34)->create()->each(function ($book) {
            $numReviews = random_int(5, 30);

            //this is wil create random data for Review with bad
            Review::factory()->count($numReviews)
                ->bad() //this is call state or custom function value
                ->for($book) //this is for belongs to (review is child of book in database)
                ->create();
        });
    }
}
