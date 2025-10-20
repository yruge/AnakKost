<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Room>
 */
class RoomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'room_number' => fake()->randomElement(['A', 'B', 'C']) . fake()->numberBetween(1, 10),
            'size' => fake()->randomElement(['4x5m', '5x5m', '6x6m']),
            'price_per_month' => fake()->randomElement(['800000', '1000000', '1200000']),
            'status' => 'available',
        ];
    }
}
