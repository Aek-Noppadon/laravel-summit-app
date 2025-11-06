<?php

namespace Database\Seeders;

use App\Models\Probability;
use Illuminate\Database\Seeder;

class probabilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $probabilities = [
            "Low < 50%",
            "Medium 50- 75%",
            "High >75%",
        ];

        foreach ($probabilities as $key => $probability) {
            Probability::create(
                ['name' => $probability],
            );
        }
    }
}
