@if ($errors->any())
    <div class="mx-6 mt-6 rounded-xl border border-red-200 bg-red-50 px-5 py-4 text-red-800">
        <p class="font-bold">Please fix the following errors:</p>
        <ul class="mt-2 list-disc space-y-1 pl-5 text-sm">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@php
    $selectedFeatures = old('features', isset($eatery) ? $eatery->features->pluck('id')->all() : []);
    $openValue = $errors->any()
        ? old('is_open')
        : old('is_open', $eatery->is_open ?? true);
@endphp

<div class="grid gap-5 px-6 py-6 md:grid-cols-2">
    <div>
        <label for="name" class="mb-2 block text-sm font-semibold text-slate-700">Name</label>
        <input id="name" type="text" name="name" maxlength="100"
               value="{{ old('name', $eatery->name ?? '') }}"
               class="w-full rounded-lg border border-slate-300 px-3 py-2.5 shadow-sm focus:border-amber-600 focus:outline-none focus:ring-2 focus:ring-amber-200">
        @error('name')<p class="mt-1 text-sm font-medium text-red-700">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="district_id" class="mb-2 block text-sm font-semibold text-slate-700">District</label>
        <select id="district_id" name="district_id"
                class="w-full rounded-lg border border-slate-300 px-3 py-2.5 shadow-sm focus:border-amber-600 focus:outline-none focus:ring-2 focus:ring-amber-200">
            <option value="">Select district</option>
            @foreach ($districts as $district)
                <option value="{{ $district->id }}"
                        @selected(old('district_id', $eatery->district_id ?? '') == $district->id)>
                    {{ $district->name }}
                </option>
            @endforeach
        </select>
        @error('district_id')<p class="mt-1 text-sm font-medium text-red-700">{{ $message }}</p>@enderror
    </div>

    <div class="md:col-span-2">
        <label for="address" class="mb-2 block text-sm font-semibold text-slate-700">Address</label>
        <input id="address" type="text" name="address" maxlength="255"
               value="{{ old('address', $eatery->address ?? '') }}"
               class="w-full rounded-lg border border-slate-300 px-3 py-2.5 shadow-sm focus:border-amber-600 focus:outline-none focus:ring-2 focus:ring-amber-200">
        @error('address')<p class="mt-1 text-sm font-medium text-red-700">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="price_range" class="mb-2 block text-sm font-semibold text-slate-700">Price range</label>
        <select id="price_range" name="price_range"
                class="w-full rounded-lg border border-slate-300 px-3 py-2.5 shadow-sm focus:border-amber-600 focus:outline-none focus:ring-2 focus:ring-amber-200">
            <option value="">Select price range</option>
            <option value="budget" @selected(old('price_range', $eatery->price_range ?? '') == 'budget')>₱ - budget</option>
            <option value="mid" @selected(old('price_range', $eatery->price_range ?? '') == 'mid')>₱₱ - mid</option>
            <option value="splurge" @selected(old('price_range', $eatery->price_range ?? '') == 'splurge')>₱₱₱ - splurge</option>
        </select>
        @error('price_range')<p class="mt-1 text-sm font-medium text-red-700">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="specialty" class="mb-2 block text-sm font-semibold text-slate-700">Specialty</label>
        <input id="specialty" type="text" name="specialty" maxlength="100"
               value="{{ old('specialty', $eatery->specialty ?? '') }}"
               class="w-full rounded-lg border border-slate-300 px-3 py-2.5 shadow-sm focus:border-amber-600 focus:outline-none focus:ring-2 focus:ring-amber-200">
        @error('specialty')<p class="mt-1 text-sm font-medium text-red-700">{{ $message }}</p>@enderror
    </div>

    <div class="md:col-span-2">
        <label class="flex w-fit items-center gap-3 rounded-lg border border-slate-200 bg-slate-50 px-4 py-3">
            <input type="checkbox" name="is_open" value="1" @checked($openValue)
                   class="h-4 w-4 rounded border-slate-300 text-amber-700 focus:ring-amber-600">
            <span class="font-semibold text-slate-700">Open</span>
        </label>
        @error('is_open')<p class="mt-1 text-sm font-medium text-red-700">{{ $message }}</p>@enderror
    </div>

    <fieldset class="md:col-span-2">
        <legend class="mb-3 text-sm font-semibold text-slate-700">Features</legend>
        <div class="grid gap-3 sm:grid-cols-2">
            @foreach ($features as $feature)
                <label class="flex cursor-pointer items-center gap-3 rounded-lg border border-slate-200 px-4 py-3 hover:border-amber-300 hover:bg-amber-50">
                    <input type="checkbox" name="features[]" value="{{ $feature->id }}"
                           @checked(in_array($feature->id, $selectedFeatures))
                           class="h-4 w-4 rounded border-slate-300 text-amber-700 focus:ring-amber-600">
                    <span class="text-sm font-medium text-slate-700">{{ $feature->name }}</span>
                </label>
            @endforeach
        </div>
        @error('features')<p class="mt-2 text-sm font-medium text-red-700">{{ $message }}</p>@enderror
        @error('features.*')<p class="mt-2 text-sm font-medium text-red-700">{{ $message }}</p>@enderror
    </fieldset>

    <div>
        <label for="permit_no" class="mb-2 block text-sm font-semibold text-slate-700">Permit number</label>
        <input id="permit_no" type="text" name="permit_no"
               value="{{ old('permit_no', $eatery->permit->permit_no ?? '') }}"
               class="w-full rounded-lg border border-slate-300 px-3 py-2.5 shadow-sm focus:border-amber-600 focus:outline-none focus:ring-2 focus:ring-amber-200">
        @error('permit_no')<p class="mt-1 text-sm font-medium text-red-700">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="expires_on" class="mb-2 block text-sm font-semibold text-slate-700">Permit expiry date</label>
        <input id="expires_on" type="date" name="expires_on"
               value="{{ old('expires_on', isset($eatery->permit) ? $eatery->permit->expires_on->format('Y-m-d') : '') }}"
               class="w-full rounded-lg border border-slate-300 px-3 py-2.5 shadow-sm focus:border-amber-600 focus:outline-none focus:ring-2 focus:ring-amber-200">
        @error('expires_on')<p class="mt-1 text-sm font-medium text-red-700">{{ $message }}</p>@enderror
    </div>
</div>
