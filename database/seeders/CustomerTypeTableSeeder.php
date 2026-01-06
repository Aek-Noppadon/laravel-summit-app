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
                    'created_user_id' => 2,
                    'updated_user_id' => 2,
                    'created_at' => '2026-01-06',
                    'updated_at' => '2026-01-06',
                ],
                [
                    'name' => 'Hot',
                    'created_user_id' => 2,
                    'updated_user_id' => 2,
                    'created_at' => '2026-01-06',
                    'updated_at' => '2026-01-06',
                ],
                [
                    'name' => 'Warm',
                    'created_user_id' => 2,
                    'updated_user_id' => 2,
                    'created_at' => '2026-01-06',
                    'updated_at' => '2026-01-06',
                ],
                [
                    'name' => 'Cold',
                    'created_user_id' => 10,
                    'updated_user_id' => 10,
                    'created_at' => '2026-01-06',
                    'updated_at' => '2026-01-06',
                ],
                [
                    'name' => 'Hot',
                    'created_user_id' => 10,
                    'updated_user_id' => 10,
                    'created_at' => '2026-01-06',
                    'updated_at' => '2026-01-06',
                ],
                [
                    'name' => 'Warm',
                    'created_user_id' => 10,
                    'updated_user_id' => 10,
                    'created_at' => '2026-01-06',
                    'updated_at' => '2026-01-06',
                ],
                [
                    'name' => 'Cold',
                    'created_user_id' => 13,
                    'updated_user_id' => 13,
                    'created_at' => '2026-01-06',
                    'updated_at' => '2026-01-06',
                ],
                [
                    'name' => 'Hot',
                    'created_user_id' => 13,
                    'updated_user_id' => 13,
                    'created_at' => '2026-01-06',
                    'updated_at' => '2026-01-06',
                ],
                [
                    'name' => 'Warm',
                    'created_user_id' => 13,
                    'updated_user_id' => 13,
                    'created_at' => '2026-01-06',
                    'updated_at' => '2026-01-06',
                ],
                [
                    'name' => 'Cold',
                    'created_user_id' => 18,
                    'updated_user_id' => 18,
                    'created_at' => '2026-01-06',
                    'updated_at' => '2026-01-06',
                ],
                [
                    'name' => 'Hot',
                    'created_user_id' => 18,
                    'updated_user_id' => 18,
                    'created_at' => '2026-01-06',
                    'updated_at' => '2026-01-06',
                ],
                [
                    'name' => 'Warm',
                    'created_user_id' => 18,
                    'updated_user_id' => 18,
                    'created_at' => '2026-01-06',
                    'updated_at' => '2026-01-06',
                ],
            )
        );
    }
}
