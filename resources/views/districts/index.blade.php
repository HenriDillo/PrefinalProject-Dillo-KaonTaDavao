@extends('layouts.app')

@section('content')
    <h1 class="text-3xl font-bold">Districts</h1>
    <div class="mt-6 grid gap-4 md:grid-cols-2">
        @foreach ($districts as $district)
            <a class="rounded border bg-white p-4" href="{{ route('districts.show', $district) }}">
                <strong>{{ $district->name }}</strong>
                <span>({{ $district->eateries_count }} eateries)</span>
            </a>
        @endforeach
    </div>
@endsection
