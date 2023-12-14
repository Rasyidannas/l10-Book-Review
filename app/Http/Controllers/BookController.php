<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //this for get input user by $request for filtering by title
        $title = $request->input('title');
        $filter = $request->input('filter', '');

        // dd(Book::all());

        // when() method will run the regular function/arrow function when first argument true and this is a method from collection. So, Books models is a colletion
        $books = Book::when(
            $title,
            fn ($query, $title) =>
            $query->title($title)
        );

        //this is for get request filter and get method in local scope in Book Model
        $books = match ($filter) {
            "popular_last_month" => $books->popularLastMonth(),
            "popular_last_6months" => $books->popularLast6Months(),
            "highest_rated_last_month" => $books->highestRatedLastMonth(),
            "highest_rated_last_6months" => $books->highestRatedLast6Months(),
            default => $books->latest()
        };

        //this for run above
        $books = $books->get();

        return view('books.index', ['books' => $books]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
