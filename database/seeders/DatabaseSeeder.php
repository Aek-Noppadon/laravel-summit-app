<?php

namespace Database\Seeders;

use App\Models\Probability;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UserTableSeeder::class);
        $this->call(DepartmentTableSeeder::class);
        $this->call(SalesStageTableSeeder::class);
        $this->call(CustomerTypeTableSeeder::class);
        $this->call(CustomerGroupTableSeeder::class);
        $this->call(ProbabilityTableSeeder::class);
        $this->call(VolumeUnitTableSeeder::class);
        $this->call(EventTableSeeder::class);
    }
}
