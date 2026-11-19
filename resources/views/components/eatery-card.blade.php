@props(['eatery'])

<article class="rounded-lg border border-amber-200 bg-white p-5 shadow-sm">
    <div class="flex items-start justify-between gap-3">
        <h2 class="text-xl font-bold">
            <a class="hover:text-amber-800" href="{{ route('eateries.show', $eatery) }}">{{ $eatery->name }}</a>
        </h2>
        @if (! $eatery->is_open)
            <span class="rounded bg-red-100 px-2 py-1 text-sm font-bold text-red-700">Closed</span>
        @endif
    </div>

    <p class="mt-2">
        <a class="text-amber-800 underline" href="{{ route('districts.show', $eatery->district) }}">{{ $eatery->district->name }}</a>
    </p>

    <p class="mt-2 font-semibold">
        @if ($eatery->price_range === 'budget')
            ₱
        @elseif ($eatery->price_range === 'mid')
            ₱₱
        @else
            ₱₱₱
        @endif
    </p>

    @if ($eatery->specialty)
        <p class="mt-2 text-slate-600">{{ $eatery->specialty }}</p>
    @endif

    <div class="mt-3 flex flex-wrap gap-2">
        @foreach ($eatery->features as $feature)
            <a class="rounded-full bg-amber-100 px-3 py-1 text-sm text-amber-900"
               href="{{ route('eateries.index', ['feature' => $feature->name]) }}">
                {{ $feature->name }}
            </a>
        @endforeach
    </div>

    <div class="mt-4">
        @php
            $reviewCount = $eatery->reviews_count ?? $eatery->reviews->count();
            $averageRating = $eatery->reviews_avg_rating ?? $eatery->reviews->avg('rating');
        @endphp
        @if ($reviewCount)
            <span class="font-semibold">{{ number_format((float) $averageRating, 1) }} ★</span>
            <span>({{ $reviewCount }} {{ $reviewCount === 1 ? 'review' : 'reviews' }})</span>
            <x-rating :rating="$averageRating" />
        @else
            <span>No reviews yet</span>
        @endif
    </div>
</article>
