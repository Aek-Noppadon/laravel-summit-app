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
                    'created_user_id' => 1,
                    'updated_user_id' => 1,
                    'created_at' => '2026-01-28',
                    'updated_at' => '2026-01-28',
                ],
                [
                    'name' => 'Qualification',
                    'created_user_id' => 1,
                    'updated_user_id' => 1,
                    'created_at' => '2026-01-28',
                    'updated_at' => '2026-01-28',
                ],
                [
                    'name' => 'Customer Approval',
                    'created_user_id' => 1,
                    'updated_user_id' => 1,
                    'created_at' => '2026-01-28',
                    'updated_at' => '2026-01-28',
                ],
                [
                    'name' => 'Closed-Won',
                    'created_user_id' => 1,
                    'updated_user_id' => 1,
                    'created_at' => '2026-01-28',
                    'updated_at' => '2026-01-28',
                ],
                [
                    'name' => 'Closed-Lost',
                    'created_user_id' => 1,
                    'updated_user_id' => 1,
                    'created_at' => '2026-01-28',
                    'updated_at' => '2026-01-28',
                ],
                [
                    'name' => 'Closed-Discontinued',
                    'created_user_id' => 1,
                    'updated_user_id' => 1,
                    'created_at' => '2026-01-28',
                    'updated_at' => '2026-01-28',
                ],
            )
        );
    }
}
