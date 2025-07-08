<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class NewsApiService
{
    protected string $apiKey;
    protected string $baseUrl = 'https://newsapi.org/v2';

    public function __construct()
    {
        $this->apiKey = config('services.newsapi.key');
    }

    /**
     * Fetch articles from NewsAPI.
     * @return array
     */
    public function fetchArticles(): array
    {
        $response = Http::get($this->baseUrl . '/top-headlines', [
            'apiKey' => $this->apiKey,
            'language' => 'en',
            'pageSize' => 20,
        ]);

        if ($response->successful()) {
            return $response->json('articles') ?? [];
        }
        return [];
    }
}