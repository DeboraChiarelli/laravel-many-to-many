<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Project; 
use Faker\Generator as Faker;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        foreach (range(1, 10) as $index) {
            Project::create([
                'title' => $faker->sentence,
                'image_path' => $faker->imageUrl(),
                'description' => $faker->paragraph,
            ]);
        }
    }
}