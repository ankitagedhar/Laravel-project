<?php

namespace Database\Factories;

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
        // Simple, raw food product names
        $foodItems = [
            'Banana',
            'Apple',
            'Orange Juice',
            'Carrot',
            'Broccoli',
            'Milk',
            'Cheddar Cheese',
            'Greek Yogurt',
            'Tomato',
            'Cucumber',
            'Eggs',
            'Almonds',
            'Lettuce',
            'Spinach',
            'Oatmeal',
            'Butter',
            'Strawberries',
            'Blueberries',
            'Avocado',
            'Coconut Water',
        ];

        return [
            'name' => $this->faker->randomElement($foodItems),
            'description' => $this->faker->sentence(),
            'price' => $this->faker->randomFloat(2, 1, 20), // $1 – $20
            'stock' => $this->faker->numberBetween(0, 100),

            // Generate a fake food-related image into storage/app/public/products
            'image' => 'products/' . $this->faker->image('storage/app/public/products', 400, 300, 'food', false),
        ];
    }
}
