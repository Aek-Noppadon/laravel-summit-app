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
                [
                    'name' => 'Personal Care',
                    'created_user_id' => 2,
                    'updated_user_id' => 2,
                    'created_at' => '2026-01-06',
                    'updated_at' => '2026-01-06',
                ],
                [
                    'name' => 'Home Care',
                    'created_user_id' => 2,
                    'updated_user_id' => 2,
                    'created_at' => '2026-01-06',
                    'updated_at' => '2026-01-06',
                ],
                [
                    'name' => 'Phama Additive',
                    'created_user_id' => 13,
                    'updated_user_id' => 13,
                    'created_at' => '2026-01-06',
                    'updated_at' => '2026-01-06',
                ],
                [
                    'name' => 'Personal Care',
                    'created_user_id' => 13,
                    'updated_user_id' => 13,
                    'created_at' => '2026-01-06',
                    'updated_at' => '2026-01-06',
                ],
                [
                    'name' => 'Home Care',
                    'created_user_id' => 13,
                    'updated_user_id' => 13,
                    'created_at' => '2026-01-06',
                    'updated_at' => '2026-01-06',
                ],
                [
                    'name' => 'Nutritional Ingredients',
                    'created_user_id' => 18,
                    'updated_user_id' => 18,
                    'created_at' => '2026-01-06',
                    'updated_at' => '2026-01-06',
                ],
            )
        );
    }
}
