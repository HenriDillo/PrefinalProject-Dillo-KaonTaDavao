@extends('layouts.app')

@section('content')
    <div class="rounded-lg border bg-white p-6">
        <div class="flex items-start justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold">{{ $eatery->name }}</h1>
                <p class="mt-2">
                    <a class="text-amber-800 underline" href="{{ route('districts.show', $eatery->district) }}">{{ $eatery->district->name }}</a>
                </p>
                @if (! $eatery->is_open)
                    <span class="mt-2 inline-block rounded bg-red-100 px-2 py-1 font-bold text-red-700">Closed</span>
                @endif
            </div>
            <div class="flex gap-2">
                <a class="rounded border px-3 py-2" href="{{ route('eateries.edit', $eatery) }}">Edit</a>
                <form method="POST" action="{{ route('eateries.destroy', $eatery) }}" onsubmit="return confirm('Delete this eatery?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="rounded bg-red-700 px-3 py-2 text-white">Delete</button>
                </form>
            </div>
        </div>

        <p class="mt-4">{{ $eatery->address }}</p>
        @if ($eatery->specialty)<p class="mt-2">{{ $eatery->specialty }}</p>@endif

        <div class="mt-4 flex flex-wrap gap-2">
            @foreach ($eatery->features as $feature)
                <a class="rounded-full bg-amber-100 px-3 py-1" href="{{ route('eateries.index', ['feature' => $feature->name]) }}">{{ $feature->name }}</a>
            @endforeach
        </div>
    </div>

    @if ($eatery->permit)
        <section class="mt-6 rounded border bg-white p-5">
            <h2 class="text-xl font-bold">Permit</h2>
            <p>{{ $eatery->permit->permit_no }}</p>
            <p>Expires on {{ $eatery->permit->expires_on->format('F j, Y') }}</p>
            @if ($eatery->permit->expires_on->isBefore(today()))
                <p class="font-bold text-red-700">Permit expired</p>
            @endif
        </section>
    @endif

    <section class="mt-6 rounded border bg-white p-5">
        <h2 class="text-xl font-bold">Dishes</h2>
        @foreach ($eatery->dishes as $dish)
            <div class="mt-3 flex justify-between border-b pb-2">
                <span>{{ $dish->name }} @if ($dish->is_bestseller)<strong>Bestseller</strong>@endif</span>
                <span>₱{{ number_format((float) $dish->price, 2) }}</span>
            </div>
        @endforeach
    </section>

    <section class="mt-6 rounded border bg-white p-5">
        <h2 class="text-xl font-bold">Reviews</h2>
        @foreach ($eatery->reviews as $review)
            <article class="mt-4 border-b pb-4">
                <p>
                    <a class="font-bold text-amber-800 underline" href="{{ route('reviewers.show', $review->user) }}">{{ $review->user->name }}</a>
                    <span>{{ $review->rating }} ★</span>
                    <x-rating :rating="$review->rating" />
                </p>
                <p class="text-sm text-slate-600">{{ $review->created_at->format('F j, Y') }}</p>
                <p class="mt-2">{{ $review->body }}</p>
                <form method="POST" action="{{ route('reviews.destroy', $review) }}" class="mt-2">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="rounded bg-red-700 px-3 py-1 text-white">Delete</button>
                </form>
            </article>
        @endforeach
    </section>

    @if ($eatery->is_open)
        <section class="mt-6 rounded-xl border border-amber-100 bg-white p-6 shadow-sm">
            <h2 class="text-xl font-bold text-slate-900">Write a Review</h2>
            <form method="POST" action="{{ route('eateries.reviews.store', $eatery) }}" class="mt-5">
                @csrf
                @include('eateries._review_form')
            </form>
        </section>
    @else
        <p class="mt-6">This eatery is closed. Reviews are paused.</p>
    @endif
@endsection
