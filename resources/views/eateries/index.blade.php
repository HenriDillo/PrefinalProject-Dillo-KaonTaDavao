@extends('layouts.app')

@section('content')
    <h1 class="text-3xl font-bold">Eateries</h1>

    <form method="GET" action="{{ route('eateries.index') }}" class="mt-6 grid gap-3 rounded border bg-white p-4 md:grid-cols-4">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Name or specialty" class="rounded border px-3 py-2">

        <select name="district" class="rounded border px-3 py-2">
            <option value="">All districts</option>
            @foreach ($districts as $district)
                <option value="{{ $district->id }}" @selected(request('district') == $district->id)>
                    {{ $district->name }}
                </option>
            @endforeach
        </select>

        <select name="feature" class="rounded border px-3 py-2">
            <option value="">All features</option>
            @foreach ($features as $feature)
                <option value="{{ $feature->name }}" @selected(request('feature') == $feature->name)>
                    {{ $feature->name }}
                </option>
            @endforeach
        </select>

        <button type="submit" class="rounded bg-amber-800 px-4 py-2 text-white">Filter</button>
    </form>

    @if ($eateries->count())
        <div class="mt-6 grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
            @foreach ($eateries as $eatery)
                <x-eatery-card :eatery="$eatery" />
            @endforeach
        </div>
        <div class="mt-6">{{ $eateries->links() }}</div>
    @else
        <p class="mt-6">No eateries match your filters.</p>
    @endif
@endsection
