<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Entrance>
 */
class EntranceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => fake()->uuid(),
            'license_plate' => fake()->unique()->word(),
            'started_at' => fake()->unixTime($max = 'now'),
            'finalized_at' => fake()->unixTime(),
            'state' => 'ACTIVE',
            'vehicle_type_id' => fake()->uuid(),
            'user_id' => fake()->numberBetween(1, 10)
        ];
    }
}
