<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "national_code" => fake()->unique()->regexify('[A-Z]{3}[0-9]{5}'),
            "aqf_level" => fake()->text(),
            "title" => fake()->word(),
            "tga_status" => fake()->text(),
            "state_code" => fake()->regexify('[A-Z]{3}[0-9]{1}'),
            "nominal_hours" => fake()->numberBetween(1,2000),
            'type' => fake()->lexify('?????'),
            "qa" => fake()->regexify('[A-Z]{3}[0-9]{1}'),
            "nat_code" => fake()->regexify('[A-Z]{3}[0-9]{5}'),
            "nat_title" => fake()->text(),
            "nat_code_title" => fake()->text(),
        ];
    }
}
