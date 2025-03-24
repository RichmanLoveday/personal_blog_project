<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
        $categories = ['Science and Technology', 'Food', 'Health and Education', 'Business and Carear', 'Education'];

        $name = fake()->randomElement($categories);
        return [
            'name' => $name,
            'status' => 'active',
            'slug' => Str::slug($name),
        ];
    }
}