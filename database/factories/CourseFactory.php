<?php
/**
 * Assessment Title: Portfolio Part 1
 * Cluster:          SaaS - BED: APIs & NoSQL - 2025 S1
 * Qualification:    ICT50220 (Advanced Programming)
 * Name:             Yui Migaki
 * Student ID:       20098757
 * Year/Semester:    2025/S1
 *
 * YOUR SUMMARY OF PORTFOLIO ACTIVITY
 * This portfolio work was conducted within a team called classTracker with 4 people.
 * I contributed by adding features for courses and packages as well as APIs for those features.
 * This project includes implementing a REST API and a management interface to create a new “Student Tracking” system.
 */

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
