<?php

namespace Database\Factories;

use App\Models\Cluster;
use App\Models\Course;
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
        $course = Course::inRandomOrder()->first();
        $cluster = Cluster::inRandomOrder()->first();

        // Semester start and end dates
        $startDate = '2025-02-03';
        $endDate = '2025-06-30';

        return [
            'course_id' => $course->national_code,
            'cluster_id' => $cluster->code,
            'name' => $cluster->title,
            'start_date' => $startDate,
            'start_time' => Carbon::createFromTime($this->faker->numberBetween(8, 18), 0)->format('H:i'),
            'weekday' => self::WEEKDAYS[$this->faker->numberBetween(1, 5)],
            'duration' => $this->faker->randomElement([2.0, 2.5, 4.0]),
            'end_date' => $endDate,
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Lesson $lesson) {
            $staff = User::whereHas('roles', function ($query) {
                $query->where('name', 'Staff');
            })->inRandomOrder()->take(2)->pluck('id');

            $student = User::whereHas('roles', function ($query) {
                $query->where('name', 'Student');
            })->inRandomOrder()->take(3)->pluck('id');

            //$users = User::inRandomOrder()->take(5)->pluck('id');

            $lesson->staff()->attach($staff);
            $lesson->students()->attach($student);
            //$lesson->users()->attach($users);
        });
    }

    const WEEKDAYS = [
        1 => 'Monday',
        2 => 'Tuesday',
        3 => 'Wednesday',
        4 => 'Thursday',
        5 => 'Friday',
//        6 => 'Sat',
//        7 => 'Sun',
    ];
}
