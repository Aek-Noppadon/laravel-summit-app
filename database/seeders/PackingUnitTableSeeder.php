<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PackingUnitTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('packing_units')->insert(
            array(
                [
                    'name' => 'Bag',
                    'created_user_id' => 1,
                    'updated_user_id' => 1,
                    'created_at' => '2026-01-06',
                    'updated_at' => '2026-01-06',
                ],
                [
                    'name' => 'Bottle',
                    'created_user_id' => 1,
                    'updated_user_id' => 1,
                    'created_at' => '2026-01-06',
                    'updated_at' => '2026-01-06',
                ],
                [
                    'name' => 'Can',
                    'created_user_id' => 1,
                    'updated_user_id' => 1,
                    'created_at' => '2026-01-06',
                    'updated_at' => '2026-01-06',
                ],
                [
                    'name' => 'EA',
                    'created_user_id' => 1,
                    'updated_user_id' => 1,
                    'created_at' => '2026-01-06',
                    'updated_at' => '2026-01-06',
                ],
            )
        );
    }
}
