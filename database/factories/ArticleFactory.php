<?php

use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArticleFactory extends Factory
{
    protected $model = Article::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
            'content' => $this->faker->paragraph,
            'source' => $this->faker->company,
            'category' => $this->faker->randomElement(['Technology', 'Health', 'Business']),
            'author' => $this->faker->name,
            'published_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}

