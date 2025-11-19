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
                    'name' => 'PERSONAL & HOME CARE',
                    'created_at' => '2025-11-10',
                    'updated_at' => '2025-11-10',
                ],
                [
                    'name' => 'INDUSTRIAL CHEMICALS',
                    'created_at' => '2025-11-10',
                    'updated_at' => '2025-11-10',
                ],
                [
                    'name' => 'NUTRITIONAL INGREDIENTS',
                    'created_at' => '2025-11-10',
                    'updated_at' => '2025-11-10',
                ],
                [
                    'name' => 'PHARMA & ACTIVES',
                    'created_at' => '2025-11-10',
                    'updated_at' => '2025-11-10',
                ],
            )
        );
    }
}
