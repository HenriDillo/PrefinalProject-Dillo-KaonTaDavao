@extends('layouts.app')

@section('content')
    <h1 class="text-3xl font-bold">{{ $user->name }}</h1>
    <p class="mt-2">{{ $user->reviews->count() }} {{ $user->reviews->count() === 1 ? 'review written' : 'reviews written' }}</p>

    <div class="mt-6 space-y-4">
        @foreach ($user->reviews as $review)
            <article class="rounded border bg-white p-4">
                <h2 class="font-bold">
                    <a class="text-amber-800 underline" href="{{ route('eateries.show', $review->eatery) }}">{{ $review->eatery->name }}</a>
                </h2>
                <p>{{ $review->rating }} ★ <x-rating :rating="$review->rating" /></p>
                <p class="mt-2">{{ $review->body }}</p>
            </article>
        @endforeach
    </div>
@endsection
