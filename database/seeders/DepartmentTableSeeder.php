<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('departments')->insert(
            array(
                [
                    'name' => 'Personal & Home Care',
                    'created_user_id' => 1,
                    'updated_user_id' => 1,
                    'created_at' => '2026-01-28',
                    'updated_at' => '2026-01-28',
                ],
                [
                    'name' => 'Industrial Chemicals',
                    'created_user_id' => 1,
                    'updated_user_id' => 1,
                    'created_at' => '2026-01-28',
                    'updated_at' => '2026-01-28',
                ],
                [
                    'name' => 'Pharma & Actives',
                    'created_user_id' => 1,
                    'updated_user_id' => 1,
                    'created_at' => '2026-01-28',
                    'updated_at' => '2026-01-28',
                ],
                [
                    'name' => 'Nutritional & Health Ingredients',
                    'created_user_id' => 1,
                    'updated_user_id' => 1,
                    'created_at' => '2026-01-28',
                    'updated_at' => '2026-01-28',
                ],
            )
        );
    }
}
