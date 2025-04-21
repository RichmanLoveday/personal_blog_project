<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->text(30);
        return [
            'title' => $title,
            'text' => fake()->text(5000),
            'slug' => Str::slug($title),
            'image' => fake()->imageUrl(),
            'is_trending' => fake()->randomElement([false, true]),
            //   'is_popular' => fake()->randomElement([false, true]),
            'is_featured' => fake()->randomElement([false, true]),
            'is_slider' => fake()->randomElement([false, true]),
            'is_banner_right_top' => fake()->randomElement([false, true]),
            'is_banner_right_bottom' => fake()->randomElement([false, true]),
            'status' => fake()->randomElement(['active', 'in-active']),
            'published_at' => fake()->randomElement([null, now()]),
        ];
    }
}
