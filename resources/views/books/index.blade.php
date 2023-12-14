@extends('layouts.app')

@section('content')
   <h1 class="mb-16 text-2xl">Books</h1>

   <form method="GET" action="{{ route('books.index') }}" class="mb-4 flex items-center space-x-2">
      {{-- this request() for can give value before in input --}}
      <input type="text" name="title" placeholder="Search by title" value="{{ request('title') }}" class="input h-10" />
      <input type="hidden" name="filter" value="{{ request('filter') }}" />
      <button type="submit" class="btn h-10">Search</button>
      <a href="{{ route('books.index') }}" class="btn h-10">Clear</a>
   </form>

   <div class="filter-container mb-4 flex">
      @php
          $filters = [
            "" => "Latest",
            "popular_last_month" => "Popular Last Month",
            "popular_last_6months" => "Popular Last 6 Months",
            "highest_rated_last_month" => "Popular Rated Last Month",
            "highest_rated_last_6month" => "Popular Rated Last 6 Months",
         ];
      @endphp

      @foreach ($filters as $key => $label)
         {{-- route with second argument can send the query in url. example this filter(books?filter=$key) and for ...request()->query() this is for add query before in url and merge it with new --}}
          <a href="{{ route('books.index', [...request()->query(), 'filter' => $key]) }}" class="{{ request('filter') === $key || (request('filter') === null && $key === '') ? 'filter-item-active' : 'filter-item' }}">
            {{ $label }}
          </a>
      @endforeach
   </div>

   <ul>
      @forelse ($books as $book)
         <li class="mb-4">
            <div class="book-item">
               <div
                  class="flex flex-wrap items-center justify-between">
                  <div class="w-full flex-grow sm:w-auto">
                     {{-- second argument route() will auto to book id --}}
                  <a href="{{ route('books.show', $book) }}" class="book-title">{{ $book->title }}</a>
                  <span class="book-author">{{ $book->author }}</span>
                  </div>
                  <div>
                  <div class="book-rating">
                     {{-- reviews_avg_rating is from Book Models --}}
                     {{ number_format($book->reviews_avg_rating, 1) }}
                  </div>
                  <div class="book-review-count">
                     out of {{ $book->reviews_count }} {{ Str::plural('review', $book->review_count) }}
                  </div>
                  </div>
               </div>
            </div>
         </li>
      @empty
         <li class="mb-4">
            <div class="empty-book-item">
            <p class="empty-text">No books found</p>
            <a href="{{ route('books.index') }}" class="reset-link">Reset criteria</a>
            </div>
         </li>
      @endforelse
   </ul>
@endsection