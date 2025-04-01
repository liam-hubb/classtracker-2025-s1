<?php

namespace Database\Factories;

use App\Models\Cluster;
use App\Models\Unit;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class UnitClusterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'unit_id' => Unit::inRandomOrder()->first()->id,
            'cluster_id' => Cluster::inRandomOrder()->first()->id,
        ];
    }
}
