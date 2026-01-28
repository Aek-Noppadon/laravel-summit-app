<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomerGroupTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('customer_groups')->insert(
            array(
                // PERSONAL & HOME CARE
                [
                    'name' => 'Personal Care',
                    'created_user_id' => 2,
                    'updated_user_id' => 2,
                    'created_at' => '2026-01-28',
                    'updated_at' => '2026-01-28',
                ],
                [
                    'name' => 'Home Care',
                    'created_user_id' => 2,
                    'updated_user_id' => 2,
                    'created_at' => '2026-01-28',
                    'updated_at' => '2026-01-28',
                ],
                // PHARMA & ACTIVES
                [
                    'name' => 'Phama Additive',
                    'created_user_id' => 18,
                    'updated_user_id' => 18,
                    'created_at' => '2026-01-28',
                    'updated_at' => '2026-01-28',
                ],
                [
                    'name' => 'Personal Care',
                    'created_user_id' => 18,
                    'updated_user_id' => 18,
                    'created_at' => '2026-01-28',
                    'updated_at' => '2026-01-28',
                ],
                [
                    'name' => 'Home Care',
                    'created_user_id' => 18,
                    'updated_user_id' => 18,
                    'created_at' => '2026-01-28',
                    'updated_at' => '2026-01-28',
                ],
                // NUTRITIONAL INGREDIENTS
                [
                    'name' => 'Nutritional Ingredients',
                    'created_user_id' => 24,
                    'updated_user_id' => 24,
                    'created_at' => '2026-01-28',
                    'updated_at' => '2026-01-28',
                ],
            )
        );
    }
}
