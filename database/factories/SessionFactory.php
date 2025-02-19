<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Session>
 */
class SessionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Fetch random records once
        $course = Course::inRandomOrder()->first();
        $cluster = Cluster::inRandomOrder()->first();
        $user = User::inRandomOrder()->first();

        // Semester start and end dates
        $startDate = '2025-02-03';
        $endDate = '2025-06-30';

        return [
            'course_id' => $course->id,
            'cluster_id' => $cluster->id,
            'start_date' => $startDate,
            'start_time' => $this->faker->time(),
            'session_duration' => $this->faker->randomFloat(1, 1.5, 4), // Random float between 1.5 and 4
            'end_date' => $endDate,
            'user_id' => $user->id,
        ];
    }
}
