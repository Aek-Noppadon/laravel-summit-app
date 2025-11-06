<?php

namespace Database\Seeders;

use App\Models\VolumnUnit;
use Illuminate\Database\Seeder;

class volumnUnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $volumnUnits = [
            "Gram",
            "Kilogram",
            "Can",
            "Liter",
        ];

        foreach ($volumnUnits as $key => $volumnUnit) {
            VolumnUnit::create(
                ['name' => $volumnUnit],
            );
        }
    }
}
