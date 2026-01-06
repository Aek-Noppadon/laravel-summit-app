<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProbabilityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('probabilities')->insert(
            array(
                [
                    'name' => 'Low < 50%',
                    'created_user_id' => 2,
                    'updated_user_id' => 2,
                    'created_at' => '2026-01-06',
                    'updated_at' => '2026-01-06',
                ],
                [
                    'name' => 'Medium 50- 75%',
                    'created_user_id' => 2,
                    'updated_user_id' => 2,
                    'created_at' => '2026-01-06',
                    'updated_at' => '2026-01-06',
                ],
                [
                    'name' => 'High >75%',
                    'created_user_id' => 2,
                    'updated_user_id' => 2,
                    'created_at' => '2026-01-06',
                    'updated_at' => '2026-01-06',
                ],
                [
                    'name' => 'Low < 50%',
                    'created_user_id' => 10,
                    'updated_user_id' => 10,
                    'created_at' => '2026-01-06',
                    'updated_at' => '2026-01-06',
                ],
                [
                    'name' => 'Medium 50- 75%',
                    'created_user_id' => 10,
                    'updated_user_id' => 10,
                    'created_at' => '2026-01-06',
                    'updated_at' => '2026-01-06',
                ],
                [
                    'name' => 'High >75%',
                    'created_user_id' => 10,
                    'updated_user_id' => 10,
                    'created_at' => '2026-01-06',
                    'updated_at' => '2026-01-06',
                ],
                [
                    'name' => 'Low < 50%',
                    'created_user_id' => 13,
                    'updated_user_id' => 13,
                    'created_at' => '2026-01-06',
                    'updated_at' => '2026-01-06',
                ],
                [
                    'name' => 'Medium 50- 75%',
                    'created_user_id' => 13,
                    'updated_user_id' => 13,
                    'created_at' => '2026-01-06',
                    'updated_at' => '2026-01-06',
                ],
                [
                    'name' => 'High >75%',
                    'created_user_id' => 13,
                    'updated_user_id' => 13,
                    'created_at' => '2026-01-06',
                    'updated_at' => '2026-01-06',
                ],
                [
                    'name' => 'Low < 50%',
                    'created_user_id' => 18,
                    'updated_user_id' => 18,
                    'created_at' => '2026-01-06',
                    'updated_at' => '2026-01-06',
                ],
                [
                    'name' => 'Medium 50- 75%',
                    'created_user_id' => 18,
                    'updated_user_id' => 18,
                    'created_at' => '2026-01-06',
                    'updated_at' => '2026-01-06',
                ],
                [
                    'name' => 'High >75%',
                    'created_user_id' => 18,
                    'updated_user_id' => 18,
                    'created_at' => '2026-01-06',
                    'updated_at' => '2026-01-06',
                ],
            )
        );
    }
}
