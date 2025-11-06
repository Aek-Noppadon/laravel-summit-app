<?php

namespace Database\Seeders;

use App\Models\CustomerGroup;
use Illuminate\Database\Seeder;

class CustomerGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customerGroups = [
            "Personal Care",
            "Home Care",
            "Pharma Additive",
            "Nutritional Ingredients",
        ];

        foreach ($customerGroups as $key => $customerGroup) {
            CustomerGroup::create(
                ['name' => $customerGroup],
            );
        }
    }
}
