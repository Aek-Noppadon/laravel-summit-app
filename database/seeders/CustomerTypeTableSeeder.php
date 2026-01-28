<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomerTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('customer_types')->insert(
            array(
                // PERSONAL & HOME CARE
                [
                    'name' => 'Cold',
                    'created_user_id' => 2,
                    'updated_user_id' => 2,
                    'created_at' => '2026-01-28',
                    'updated_at' => '2026-01-28',
                ],
                [
                    'name' => 'Hot',
                    'created_user_id' => 2,
                    'updated_user_id' => 2,
                    'created_at' => '2026-01-28',
                    'updated_at' => '2026-01-28',
                ],
                [
                    'name' => 'Warm',
                    'created_user_id' => 2,
                    'updated_user_id' => 2,
                    'created_at' => '2026-01-28',
                    'updated_at' => '2026-01-28',
                ],
                [
                    'name' => 'New',
                    'created_user_id' => 2,
                    'updated_user_id' => 2,
                    'created_at' => '2026-01-28',
                    'updated_at' => '2026-01-28',
                ],
                // INDUSTRIAL CHEMICALS
                [
                    'name' => 'Cold',
                    'created_user_id' => 12,
                    'updated_user_id' => 12,
                    'created_at' => '2026-01-28',
                    'updated_at' => '2026-01-28',
                ],
                [
                    'name' => 'Hot',
                    'created_user_id' => 12,
                    'updated_user_id' => 12,
                    'created_at' => '2026-01-28',
                    'updated_at' => '2026-01-28',
                ],
                [
                    'name' => 'Warm',
                    'created_user_id' => 12,
                    'updated_user_id' => 12,
                    'created_at' => '2026-01-28',
                    'updated_at' => '2026-01-28',
                ],
                // PHARMA & ACTIVES
                [
                    'name' => 'Cold',
                    'created_user_id' => 18,
                    'updated_user_id' => 18,
                    'created_at' => '2026-01-28',
                    'updated_at' => '2026-01-28',
                ],
                [
                    'name' => 'Hot',
                    'created_user_id' => 18,
                    'updated_user_id' => 18,
                    'created_at' => '2026-01-28',
                    'updated_at' => '2026-01-28',
                ],
                [
                    'name' => 'Warm',
                    'created_user_id' => 18,
                    'updated_user_id' => 18,
                    'created_at' => '2026-01-28',
                    'updated_at' => '2026-01-28',
                ],
                // NUTRITIONAL INGREDIENTS
                [
                    'name' => 'Cold',
                    'created_user_id' => 24,
                    'updated_user_id' => 24,
                    'created_at' => '2026-01-28',
                    'updated_at' => '2026-01-28',
                ],
                [
                    'name' => 'Hot',
                    'created_user_id' => 24,
                    'updated_user_id' => 24,
                    'created_at' => '2026-01-28',
                    'updated_at' => '2026-01-28',
                ],
                [
                    'name' => 'Warm',
                    'created_user_id' => 24,
                    'updated_user_id' => 24,
                    'created_at' => '2026-01-28',
                    'updated_at' => '2026-01-28',
                ],
            )
        );
    }
}
