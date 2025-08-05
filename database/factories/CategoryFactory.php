<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
       $categories = [
            'أجهزة إلكترونية',
            'ملابس',
            'أثاث',
            'ألعاب',
            'كتب',
            'مواد غذائية',
            'أدوات منزلية',
            'رياضة',
            'جمال',
            'سيارات',
            'Electronics',
            'Clothing',
            'Furniture',
            'Toys',
            'Books',
            'Groceries',
            'Home Appliances',
            'Sports',
            'Beauty',
            'Automotive'
        ];

        $name = $this->faker->unique()->randomElement($categories);

        return [
            'name' => $name,
            'slug' => Str::slug($name),
        ];
    }
}
