<?php

namespace Database\Seeders;

use App\Models\SalesStage;
use Illuminate\Database\Seeder;

class salesStageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $salesStates = [
            "Identification",
            "Qualification",
            "Customer Approval",
            "Closed-Won",
            "Closed-Lost",
            "Closed-Discontinued",
        ];

        foreach ($salesStates as $key => $salesState) {
            SalesStage::create(
                ['name' => $salesState],
            );
        }
    }
}
