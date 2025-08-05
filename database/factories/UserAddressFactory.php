<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserAddress>
 */
class UserAddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $arabicCities = ['الرياض', 'جدة', 'القاهرة', 'دبي', 'عمّان'];
        $englishCities = ['Riyadh', 'Jeddah', 'Cairo', 'Dubai', 'Amman'];

        return [
            'type' => $this->faker->randomElement(['shp', 'bil', 'hom']),
            'address1' => $this->faker->streetAddress,
            'address2' => $this->faker->optional(40)->secondaryAddress,
            'state' => $this->faker->optional()->state,
            'city' => $this->faker->randomElement(array_merge($arabicCities, $englishCities)),
            'zipcode' => $this->faker->postcode,
            'isMain' => $this->faker->boolean(80), // 80% احتمال أن يكون رئيسي
            'cuntry_code' => $this->faker->countryCode,
            'user_id' => User::inRandomOrder()->first()->id ?? User::factory()->create()->id,
        ];
    }
}
