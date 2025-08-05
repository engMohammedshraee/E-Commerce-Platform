<?php

namespace Database\Factories;

use App\Models\UserAddress;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
          $statuses = ['pending', 'processing', 'shipped', 'delivered', 'cancelled'];

        return [
            'total_prices' => $this->faker->randomFloat(2, 100, 10000),
            'status' => $this->faker->randomElement($statuses),
            'user_Address_id' => UserAddress::inRandomOrder()->first()->id,
            'created_by' => User::inRandomOrder()->first()->id,
            'updated_by' => User::inRandomOrder()->first()->id,
            'session_id' => $this->faker->uuid,
        ];
    }
}
