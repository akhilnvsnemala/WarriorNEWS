<?php namespace App\Console\Commands;

use App\Models\Article;
use App\Models\Category;
use App\Models\Source;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class FetchArticlesCommand extends Command
{
    protected $signature = 'fetch:articles';
    protected $description = 'Fetch articles from news APIs and store them in the database';

    public function handle()
    {
        $this->info('Fetching articles...');

        $newsApis = [
            [
                'name' => 'NewsAPI',
                'endpoint' => 'https://newsapi.org/v2/top-headlines',
                'api_key' => config('services.newsapi.key'),
            ]
        ];

        foreach ($newsApis as $api) {
            $this->fetchFromApi($api);
        }

        $this->info('Articles fetched successfully!');
    }

    private function fetchFromApi($api)
    {
        $response = Http::get($api['endpoint'], [
            'apiKey' => $api['api_key'],
            'country' => 'us',
            'pageSize' => 50,
        ]);

        if ($response->failed()) {
            $this->error("Failed to fetch from {$api['name']}. Status: {$response->status()}");
            $this->error("Response Body: " . $response->body());
            return;
        }

        $articles = $response->json()['articles'] ?? [];

        if (empty($articles)) {
            $this->info("No articles found from {$api['name']}.");
            return;
        }

        foreach ($articles as $article) {
            $source = Source::firstOrCreate(['name' => $article['source']['name']]);
            $category = Category::firstOrCreate(['name' => 'General', 'slug' => 'general']);

            Article::updateOrCreate(
                ['url' => $article['url']],
                [
                    'title' => $article['title'],
                    'slug' => \Str::slug($article['title']),
                    'content' => $article['content'] ?? $article['description'] ?? '',
                    'image_url' => $article['urlToImage'] ?? null,
                    'published_at' => $article['publishedAt'] ?? now(),
                    'category_id' => $category->id,
                    'source_id' => $source->id,
                ]
            );
        }

        $this->info("Articles fetched from {$api['name']} successfully!");
    }
}
