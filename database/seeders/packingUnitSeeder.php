<?php

namespace Database\Seeders;

use App\Models\PackingUnit;
use Illuminate\Database\Seeder;

class packingUnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $packingUnits = [
            "Bag",
            "Bottle",
            "Can",
            "EA",
        ];

        foreach ($packingUnits as $key => $packingUnit) {
            PackingUnit::create(
                ['name' => $packingUnit],
            );
        }
    }
}
