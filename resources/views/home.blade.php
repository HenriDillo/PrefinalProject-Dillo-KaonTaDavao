@extends('layouts.app')

@section('content')
    <h1 class="text-3xl font-bold">Kaon Ta! Davao</h1>

    <div class="mt-6 grid gap-4 sm:grid-cols-3">
        <div class="rounded border bg-white p-4"><strong>{{ $eateryCount }}</strong> eateries</div>
        <div class="rounded border bg-white p-4"><strong>{{ $districtCount }}</strong> districts</div>
        <div class="rounded border bg-white p-4"><strong>{{ $reviewCount }}</strong> reviews</div>
    </div>

    <h2 class="mt-8 text-2xl font-bold">Top Rated</h2>
    <div class="mt-4 grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
        @foreach ($topRated as $eatery)
            <x-eatery-card :eatery="$eatery" />
        @endforeach
    </div>
@endsection
