<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Package;


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

//        $course = Course::inRandomOrder()->first();

        return [
            'national_code' => strtoupper($this->faker->lexify('???')),
            'title' => $this->faker->sentence(3),
            'tga_status' => $this->faker->sentence(7),
        ];
    }
}



