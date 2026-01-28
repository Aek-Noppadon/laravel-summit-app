<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VolumeUnitTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('volume_units')->insert(
            array(
                // PERSONAL & HOME CARE
                [
                    'name' => 'Kilogram',
                    'created_user_id' => 2,
                    'updated_user_id' => 2,
                    'created_at' => '2026-01-28',
                    'updated_at' => '2026-01-28',
                ],
                // INDUSTRIAL CHEMICALS
                [
                    'name' => 'Kilogram',
                    'created_user_id' => 12,
                    'updated_user_id' => 12,
                    'created_at' => '2026-01-28',
                    'updated_at' => '2026-01-28',
                ],
                // PHARMA & ACTIVES
                [
                    'name' => 'Kilogram',
                    'created_user_id' => 18,
                    'updated_user_id' => 18,
                    'created_at' => '2026-01-28',
                    'updated_at' => '2026-01-28',
                ],
                // NUTRITIONAL INGREDIENTS
                [
                    'name' => 'Kilogram',
                    'created_user_id' => 24,
                    'updated_user_id' => 24,
                    'created_at' => '2026-01-28',
                    'updated_at' => '2026-01-28',
                ],
            )
        );
    }
}
