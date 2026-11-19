<?php

namespace Database\Seeders;

use App\Models\District;
use App\Models\Dish;
use App\Models\Eatery;
use App\Models\Feature;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class EaterySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $poblacion = District::where('name', 'Poblacion')->first();

        $eatery = Eatery::create([
            'district_id' => $poblacion->id,
            'name' => 'Carinderia ni Dillo',
            'slug' => Str::slug('Carinderia ni Dillo'),
            'address' => 'San Pedro St., Poblacion, Davao City',
            'price_range' => 'budget',
            'specialty' => 'Tinolang Manok',
            'is_open' => true,
        ]);

        $eatery->permit()->create([
            'permit_no' => 'DVO-2026-0817',
            'expires_on' => '2027-08-17',
        ]);

        $eatery->dishes()->create([
            'name' => 'Tinolang Manok',
            'price' => 85.00,
            'is_bestseller' => true,
        ]);
        $eatery->dishes()->create([
            'name' => 'Kinilaw na Tuna',
            'price' => 120.00,
            'is_bestseller' => false,
        ]);
        $eatery->dishes()->create([
            'name' => 'Durian Shake',
            'price' => 75.00,
            'is_bestseller' => false,
        ]);

        $eatery->features()->sync([
            Feature::where('name', 'Suki ni Dillo')->first()->id,
            Feature::where('name', 'Budget Meal')->first()->id,
        ]);

        $openEateries = Eatery::factory()->count(11)->create();
        $closedEateries = Eatery::factory()->closed()->count(3)->create();
        $factoryEateries = $openEateries->concat($closedEateries);
        $featureIds = Feature::pluck('id')->all();

        foreach ($factoryEateries as $index => $factoryEatery) {
            $expiresOn = $index === 0
                ? '2025-01-01'
                : fake()->dateTimeBetween('2027-01-01', '2030-12-31')->format('Y-m-d');

            $factoryEatery->permit()->create([
                'permit_no' => fake()->unique()->numerify('DVO-2026-####'),
                'expires_on' => $expiresOn,
            ]);

            Dish::factory()->count(rand(2, 5))->create([
                'eatery_id' => $factoryEatery->id,
            ]);

            $factoryEatery->features()->attach(
                collect($featureIds)->random(rand(1, 3))->all()
            );
        }
    }
}
