<?php

namespace Database\Factories;

use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'tenant_id' => Tenant::factory(),
            'amount'=>fake()->randomElement([800000, 1000000, 1200000]),
            'payment_date'=>fake()->dateTimeThisMonth(),
            'for_period'=> 'September 2025',
            'status' => 'paid',
        ];
    }
}
