<?php

namespace Database\Seeders;

use App\Models\Eatery;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $eatery = Eatery::where('slug', 'carinderia-ni-dillo')->first();
        $tita = User::where('email', 'tita.dillo@kaonta.test')->first();
        $henri = User::where('email', 'dillo@kaonta.test')->first();

        $eatery->reviews()->create([
            'user_id' => $tita->id,
            'rating' => 5,
            'body' => 'Lami kaayo! Balik-balikan ni Tita Dillo.',
        ]);

        $eatery->reviews()->create([
            'user_id' => $henri->id,
            'rating' => 4,
            'body' => 'Fresh and tasty dishes every time.',
        ]);

        $eatery->reviews()->create([
            'user_id' => $tita->id,
            'rating' => 5,
            'body' => 'A comfortable place for a quick meal.',
        ]);

        $openEateries = Eatery::where('is_open', true)
            ->where('slug', '!=', 'carinderia-ni-dillo')
            ->get();

        foreach ($openEateries as $openEatery) {
            $count = rand(0, 6);

            if ($count > 0) {
                Review::factory()->count($count)->create([
                    'eatery_id' => $openEatery->id,
                ]);
            }
        }
    }
}
