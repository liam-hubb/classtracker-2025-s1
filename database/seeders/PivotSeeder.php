<?php

namespace Database\Seeders;

use App\Models\Cluster;
use App\Models\Course;
use App\Models\Unit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PivotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        {
            Course::all()->each(function ($course) {
                $units = Unit::inRandomOrder()->limit(rand(1, 8))->pluck('id');
                $course->units()->attach($units);
            });

            Cluster::all()->each(function ($clusters) {
                $units = Unit::inRandomOrder()->limit(rand(1, 8))->get();
                $clusters->units()->createMany(
                    $units->toArray()
                );
            });

        }
    }
}
