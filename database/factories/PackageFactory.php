<?php

namespace Database\Factories;

use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Package>
 */
class PackageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $course = Course::inRandomOrder()->first();

        return [
            "national_code" => fake()->unique(),
            "title" => fake()->word(),
            "tga_status" => fake()->text(),
            'course_id' => $course->national_code,
        ];
    }
}
