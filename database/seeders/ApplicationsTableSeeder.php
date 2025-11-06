<?php

namespace Database\Seeders;

use App\Models\Application;
use Illuminate\Database\Seeder;

class ApplicationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $applications = [
            // ['name' => "Skin care", 'created_at' => "2025-09-08", 'updated_at' => "2025-09-08"],
            // ['name' => "Skin care", 'created_at' => "2025-09-08", 'updated_at' => "2025-09-08"],
            "Skin care",
            "Sunscreen",
            "Hair care",
            "Serum",
            "Treatment",
            "Serum Guerlain",
            "Sun care",
            "Facial care",
        ];


        // dd($applications);

        foreach ($applications as $key => $application) {
            Application::create(
                ['name' => $application],
            );
        }
    }
}
