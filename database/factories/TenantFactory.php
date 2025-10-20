<?php

namespace Database\Factories;
use App\Models\Room;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tenant>
 */
class TenantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        return [
            'room_id' => Room::inRandomOrder()->first()->id,
            'name' => fake()->name(),
            'phone_number' => fake()->phoneNumber(),
            'ktp_photo' => fake()->imageUrl(640, 480, 'people'),
            'move_in_date' => fake()->dateTimeThisYear(),
        ];
    }
}
