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
        DB::table('volumn_units')->insert(
            array(
                [
                    'name' => 'Gram',
                    'created_at' => '2025-11-10',
                    'updated_at' => '2025-11-10',
                ],
                [
                    'name' => 'Kilogram',
                    'created_at' => '2025-11-10',
                    'updated_at' => '2025-11-10',
                ],
                [
                    'name' => 'Can',
                    'created_at' => '2025-11-10',
                    'updated_at' => '2025-11-10',
                ],
                [
                    'name' => 'Liter',
                    'created_at' => '2025-11-10',
                    'updated_at' => '2025-11-10',
                ],
            )
        );
    }
}
