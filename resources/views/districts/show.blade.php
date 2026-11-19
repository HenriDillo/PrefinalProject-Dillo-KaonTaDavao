@extends('layouts.app')

@section('content')
    <h1 class="text-3xl font-bold">{{ $district->name }}</h1>
    <p class="mt-2">
        {{ $district->reviews_count }} {{ $district->reviews_count === 1 ? 'review' : 'reviews' }} in {{ $district->name }}
    </p>

    <div class="mt-6 grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
        @foreach ($district->eateries as $eatery)
            <x-eatery-card :eatery="$eatery" />
        @endforeach
    </div>
@endsection
