<?php

namespace Database\Factories;
use App\Models\Room;
use App\Models\User;

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
        $user = User::factory()->create([
            'name' => $this->faker->name(),
        ]);

        return [
            'user_id' => $user->id,
            'room_id' => Room::where('status', 'available')->inRandomOrder()->first()?->id,
            'name' => $user->name,
            'phone_number' => fake()->phoneNumber(),
            'ktp_photo' => fake()->imageUrl(640, 480, 'people'),
            'move_in_date' => fake()->dateTimeThisYear(),
        ];
    }
}
