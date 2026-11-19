<?php

namespace App\Http\Controllers;

use App\Models\Eatery;
use App\Models\District;
use App\Models\Feature;
use App\Http\Requests\StoreEateryRequest;
use App\Http\Requests\UpdateEateryRequest;
use Illuminate\Support\Str;

class EateryController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        $eateries = Eatery::query()
            ->with(['district', 'features', 'reviews'])
            ->withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->when($request->q, function ($query, $q) {
                $query->where(function ($search) use ($q) {
                    $search->where('name', 'like', '%' . $q . '%')
                        ->orWhere('specialty', 'like', '%' . $q . '%');
                });
            })
            ->when($request->district, function ($query, $districtId) {
                $query->where('district_id', $districtId);
            })
            ->when($request->feature, function ($query, $featureName) {
                $query->whereHas('features', function ($featureQuery) use ($featureName) {
                    $featureQuery->where('name', $featureName);
                });
            })
            ->orderBy('name')
            ->paginate(6)
            ->withQueryString();

        $districts = District::orderBy('name')->get();
        $features = Feature::orderBy('name')->get();

        return view('eateries.index', compact('eateries', 'districts', 'features'));
    }

    public function create()
    {
        $districts = District::orderBy('name')->get();
        $features = Feature::orderBy('name')->get();

        return view('eateries.create', compact('districts', 'features'));
    }

    public function store(StoreEateryRequest $request)
    {
        $validated = $request->validated();

        $eatery = Eatery::create([
            'district_id' => $validated['district_id'],
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'address' => $validated['address'],
            'price_range' => $validated['price_range'],
            'specialty' => $validated['specialty'] ?? null,
            'is_open' => (bool) ($validated['is_open'] ?? false),
        ]);

        $eatery->permit()->create([
            'permit_no' => $validated['permit_no'],
            'expires_on' => $validated['expires_on'],
        ]);
        $eatery->features()->sync($validated['features']);

        return redirect()->route('eateries.show', $eatery)
            ->with('success', 'Eatery added.');
    }

    public function show(Eatery $eatery)
    {
        $eatery->load([
            'district',
            'permit',
            'dishes',
            'features',
            'reviews' => function ($query) {
                $query->with('user')->latest();
            },
        ]);
        $eatery->loadAvg('reviews', 'rating');
        $eatery->loadCount('reviews');

        $users = \App\Models\User::orderBy('name')->get();

        return view('eateries.show', compact('eatery', 'users'));
    }

    public function edit(Eatery $eatery)
    {
        $eatery->load(['permit', 'features']);
        $districts = District::orderBy('name')->get();
        $features = Feature::orderBy('name')->get();

        return view('eateries.edit', compact('eatery', 'districts', 'features'));
    }

    public function update(UpdateEateryRequest $request, Eatery $eatery)
    {
        $validated = $request->validated();

        $eatery->update([
            'district_id' => $validated['district_id'],
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'address' => $validated['address'],
            'price_range' => $validated['price_range'],
            'specialty' => $validated['specialty'] ?? null,
            'is_open' => (bool) ($validated['is_open'] ?? false),
        ]);

        $eatery->permit()->update([
            'permit_no' => $validated['permit_no'],
            'expires_on' => $validated['expires_on'],
        ]);
        $eatery->features()->sync($validated['features']);

        return redirect()->route('eateries.show', $eatery)
            ->with('success', 'Eatery updated.');
    }

    public function destroy(Eatery $eatery)
    {
        $eatery->permit()->delete();
        $eatery->dishes()->delete();
        $eatery->reviews()->delete();
        $eatery->features()->detach();
        $eatery->delete();

        return redirect()->route('eateries.index')
            ->with('success', 'Eatery deleted.');
    }
}
