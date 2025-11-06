<?php

namespace Database\Seeders;

use App\Models\CustomerType;
use Illuminate\Database\Seeder;

class CustomerTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customerTypes = [
            "Cold",
            "Hot",
            "Warm",
        ];

        foreach ($customerTypes as $key => $customerType) {
            CustomerType::create(
                ['name' => $customerType],
            );
        }
    }
}
