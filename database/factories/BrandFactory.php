<?php

namespace Database\Factories;
use Illuminate\Support\Str;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Brand>
 */
class BrandFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
         $brandNames = [
            'سامسونج', 'أبل', 'هواوي', 'إل جي', 'سوني',
            'نوكيا', 'شاومي', 'ديل', 'إتش بي', 'كانون',
            'Samsung', 'Apple', 'Huawei', 'LG', 'Sony',
            'Nokia', 'Xiaomi', 'Dell', 'HP', 'Canon'
        ];

        $name = $this->faker->unique()->randomElement($brandNames);

        return [
            'name' => $name,
            'slug' => Str::slug($name),
        ];
    }
}
