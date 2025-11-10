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
                [
                    'name' => 'Cold',
                    'created_at' => '2025-11-10',
                    'updated_at' => '2025-11-10',
                ],
                [
                    'name' => 'Hot',
                    'created_at' => '2025-11-10',
                    'updated_at' => '2025-11-10',
                ],
                [
                    'name' => 'Warm',
                    'created_at' => '2025-11-10',
                    'updated_at' => '2025-11-10',
                ],
            )
        );
    }
}
