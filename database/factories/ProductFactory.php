<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
           $titles = [
            'حاسوب محمول إل جي جرام',
            'هاتف سامسونج جالاكسي S22',
            'ساعة أبل الذكية Series 7',
            'سماعات سوني اللاسلكية',
            'كاميرا كانون EOS R6',
            'حقيبة ظهر تيسلا للكمبيوتر',
            'جهاز آيباد برو 2022',
            'ماوس لوجيتك MX Master 3',
            'لوحة مفاتيح ميكانيكية RGB',
            'شاشة منحنية سامسونج 32 بوصة'
        ];

        return [
            'title' => $this->faker->randomElement($titles),
            'slug' => $this->faker->unique()->slug,
            'quantity' => $this->faker->numberBetween(0, 100),
            'description' => $this->faker->paragraph(3),
            'published' => $this->faker->boolean(70), // 70% احتمال يكون published
            'inStock' => $this->faker->boolean(80), // 80% احتمال يكون متوفر
            'price' => $this->faker->randomFloat(2, 50, 5000),
            'created_by' => User::inRandomOrder()->first()->id,
            'updated_by' => User::inRandomOrder()->first()->id,
            'brand_id' => Brand::inRandomOrder()->first()->id,
            'category_id' => Category::inRandomOrder()->first()->id,
            'deleted_by' => null // سيتم تعيينه فقط عند الحذف
        ];
    }
}
