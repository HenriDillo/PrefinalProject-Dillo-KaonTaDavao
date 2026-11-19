<?php

namespace Database\Factories;

use App\Models\Permit;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Permit>
 */
class PermitFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'permit_no' => fake()->unique()->numerify('DVO-2026-####'),
            'expires_on' => fake()->dateTimeBetween('2027-01-01', '2030-12-31')->format('Y-m-d'),
        ];
    }
}
