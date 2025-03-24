<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::factory(3)->create();

        User::factory(5)->has(
            Article::factory(15)
                ->for(
                    $categories->random(),
                    'category'
                ),
            'articles'
        )->create();
    }
}
