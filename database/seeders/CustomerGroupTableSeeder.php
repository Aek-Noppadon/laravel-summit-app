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
        DB::table('customer_types')->insert(
            array(
                [
                    'name' => 'Personal Care',
                    'created_at' => '2025-11-10',
                    'updated_at' => '2025-11-10',
                ],
                [
                    'name' => 'Home Care',
                    'created_at' => '2025-11-10',
                    'updated_at' => '2025-11-10',
                ],
                [
                    'name' => 'Phama Additive',
                    'created_at' => '2025-11-10',
                    'updated_at' => '2025-11-10',
                ],
                [
                    'name' => 'Phama Additive',
                    'created_at' => '2025-11-10',
                    'updated_at' => '2025-11-10',
                ],
                [
                    'name' => 'Nutritional Ingredients',
                    'created_at' => '2025-11-10',
                    'updated_at' => '2025-11-10',
                ],
            )
        );
    }
}
