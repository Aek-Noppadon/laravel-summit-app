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
        $this->call(CustomerTypeTableSeeder::class);
        $this->call(CustomerGroupTableSeeder::class);
        $this->call(ApplicationTableSeeder::class);
        $this->call(SalesStageTableSeeder::class);
        $this->call(ProbabilityTableSeeder::class);
        $this->call(PackingUnitTableSeeder::class);
        $this->call(VolumnUnitTableSeeder::class);

        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
