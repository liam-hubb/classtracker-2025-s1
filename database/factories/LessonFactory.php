<?php

namespace Database\Factories;

use App\Models\Clusters;
use App\Models\Courses;
use App\Models\Lesson;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Lesson>
 */
class LessonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Fetch random records once
        $course = Courses::inRandomOrder()->first();
        $cluster = Clusters::inRandomOrder()->first();

        // Semester start and end dates
        $startDate = '2025-02-03';
        $endDate = '2025-06-30';

        return [
            'course_id' => $course->national_code,
            'cluster_id' => $cluster->code,
            'name' => $cluster->title,
            'start_date' => $startDate,
            'start_time' => Carbon::createFromTime($this->faker->numberBetween(8,18),0)->format('H:i'),
            'weekday' => self::WEEKDAYS[$this->faker->numberBetween(1, 5)],
            'duration' => $this->faker->randomElement([2.0, 2.5, 4.0]),
            'end_date' => $endDate,
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Lesson $lesson) {
            $users = User::inRandomOrder()->take(2)->pluck('id');
            $lesson->users()->attach($users);
        });
    }

    const WEEKDAYS = [
        1 => 'Mon',
        2 => 'Tues',
        3 => 'Wed',
        4 => 'Thu',
        5 => 'Fri',
//        6 => 'Sat',
//        7 => 'Sun',
    ];
}
