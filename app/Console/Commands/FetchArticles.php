<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\NewsApiService;
use App\Services\GuardianApiService;
use App\Services\BbcNewsService;
use App\Models\Article;
use App\Models\Source;
use App\Models\Category;
use App\Models\Author;
use Carbon\Carbon;

class FetchArticles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fetch-articles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // NewsAPI
        $newsApiService = new NewsApiService();
        $articles = $newsApiService->fetchArticles();
        $source = Source::where('api_identifier', 'newsapi')->first();
        $newCount = 0;

        foreach ($articles as $item) {
            if (Article::where('url', $item['url'])->exists()) {
                continue;
            }
            $author = null;
            if (!empty($item['author'])) {
                $author = Author::firstOrCreate(['name' => $item['author']]);
            }
            $category = null;
            if (!empty($item['category'])) {
                $category = Category::firstOrCreate(['name' => $item['category']]);
            }
            Article::create([
                'title' => $item['title'] ?? '',
                'description' => $item['description'] ?? '',
                'content' => $item['content'] ?? '',
                'url' => $item['url'],
                'image_url' => $item['urlToImage'] ?? null,
                'published_at' => isset($item['publishedAt']) ? Carbon::parse($item['publishedAt'])->format('Y-m-d H:i:s') : null,
                'source_id' => $source ? $source->id : null,
                'category_id' => $category ? $category->id : null,
                'author_id' => $author ? $author->id : null,
            ]);
            $newCount++;
        }
        $this->info('Fetched ' . count($articles) . ' articles from NewsAPI. Added ' . $newCount . ' new articles.');

        // The Guardian
        $guardianService = new GuardianApiService();
        $guardianArticles = $guardianService->fetchArticles();
        $guardianSource = Source::where('api_identifier', 'guardian')->first();
        $guardianNewCount = 0;

        foreach ($guardianArticles as $item) {
            if (Article::where('url', $item['url'])->exists()) {
                continue;
            }
            $author = null;
            if (!empty($item['author'])) {
                $author = Author::firstOrCreate(['name' => $item['author']]);
            }
            $category = null;
            if (!empty($item['category'])) {
                $category = Category::firstOrCreate(['name' => $item['category']]);
            }
            Article::create([
                'title' => $item['title'] ?? '',
                'description' => $item['description'] ?? '',
                'content' => $item['content'] ?? '',
                'url' => $item['url'],
                'image_url' => $item['image_url'] ?? null,
                'published_at' => isset($item['published_at']) ? Carbon::parse($item['published_at'])->format('Y-m-d H:i:s') : null,
                'source_id' => $guardianSource ? $guardianSource->id : null,
                'category_id' => $category ? $category->id : null,
                'author_id' => $author ? $author->id : null,
            ]);
            $guardianNewCount++;
        }
        $this->info('Fetched ' . count($guardianArticles) . ' articles from The Guardian. Added ' . $guardianNewCount . ' new articles.');

        // BBC News
        $bbcService = new BbcNewsService();
        $bbcArticles = $bbcService->fetchArticles();
        $bbcSource = Source::where('api_identifier', 'bbc')->first();
        $bbcNewCount = 0;

        foreach ($bbcArticles as $item) {
            if (Article::where('url', $item['url'])->exists()) {
                continue;
            }
            $author = null;
            if (!empty($item['author'])) {
                $author = Author::firstOrCreate(['name' => $item['author']]);
            }
            $category = null;
            if (!empty($item['category'])) {
                $category = Category::firstOrCreate(['name' => $item['category']]);
            }
            Article::create([
                'title' => $item['title'] ?? '',
                'description' => $item['description'] ?? '',
                'content' => $item['content'] ?? '',
                'url' => $item['url'],
                'image_url' => $item['image_url'] ?? null,
                'published_at' => isset($item['published_at']) ? Carbon::parse($item['published_at'])->format('Y-m-d H:i:s') : null,
                'source_id' => $bbcSource ? $bbcSource->id : null,
                'category_id' => $category ? $category->id : null,
                'author_id' => $author ? $author->id : null,
            ]);
            $bbcNewCount++;
        }
        $this->info('Fetched ' . count($bbcArticles) . ' articles from BBC News. Added ' . $bbcNewCount . ' new articles.');
    }
}
