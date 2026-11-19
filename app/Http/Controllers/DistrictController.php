<?php

namespace App\Http\Controllers;

use App\Models\District;
use Illuminate\Http\Request;

class DistrictController extends Controller
{
    public function index()
    {
        $districts = District::withCount('eateries')->orderBy('name')->get();

        return view('districts.index', compact('districts'));
    }

    public function show(District $district)
    {
        $district->load([
            'eateries.district',
            'eateries.features',
            'eateries.reviews',
        ]);
        $district->loadCount('reviews');

        return view('districts.show', compact('district'));
    }
}
