<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SalesStageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('sales_stages')->insert(
            array(
                [
                    'name' => 'Identification',
                    'created_at' => '2025-11-10',
                    'updated_at' => '2025-11-10',
                ],
                [
                    'name' => 'Qualification',
                    'created_at' => '2025-11-10',
                    'updated_at' => '2025-11-10',
                ],
                [
                    'name' => 'Customer Approval',
                    'created_at' => '2025-11-10',
                    'updated_at' => '2025-11-10',
                ],
                [
                    'name' => 'Closed-Won',
                    'created_at' => '2025-11-10',
                    'updated_at' => '2025-11-10',
                ],
                [
                    'name' => 'Closed-Lost',
                    'created_at' => '2025-11-10',
                    'updated_at' => '2025-11-10',
                ],
                [
                    'name' => 'Closed-Discontinued',
                    'created_at' => '2025-11-10',
                    'updated_at' => '2025-11-10',
                ],
            )
        );
    }
}
