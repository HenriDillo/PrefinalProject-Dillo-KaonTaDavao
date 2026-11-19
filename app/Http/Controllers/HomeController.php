<?php

namespace App\Http\Controllers;

use App\Models\Eatery;
use App\Models\District;
use App\Models\Review;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $topRated = Eatery::query()
            ->has('reviews')
            ->with(['district', 'features', 'reviews'])
            ->withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->orderByDesc('reviews_avg_rating')
            ->orderBy('name')
            ->take(3)
            ->get();

        return view('home', [
            'eateryCount' => Eatery::count(),
            'districtCount' => District::count(),
            'reviewCount' => Review::count(),
            'topRated' => $topRated,
        ]);
    }
}
