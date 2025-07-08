<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GuardianApiService
{
    protected string $apiKey;
    protected string $baseUrl = 'https://content.guardianapis.com/search';

    public function __construct()
    {
        $this->apiKey = config('services.guardian.key');
    }

    /**
     * Fetch articles from The Guardian API.
     * @return array
     */
    public function fetchArticles(): array
    {
        $response = Http::get($this->baseUrl, [
            'api-key' => $this->apiKey,
            'show-fields' => 'headline,trailText,body,thumbnail,byline',
            'page-size' => 20,
        ]);

        if ($response->successful() && isset($response['response']['results'])) {
            $articles = [];
            foreach ($response['response']['results'] as $item) {
                $fields = $item['fields'] ?? [];
                $articles[] = [
                    'title' => $fields['headline'] ?? $item['webTitle'] ?? '',
                    'description' => $fields['trailText'] ?? '',
                    'content' => $fields['body'] ?? '',
                    'url' => $item['webUrl'] ?? '',
                    'image_url' => $fields['thumbnail'] ?? null,
                    'published_at' => $item['webPublicationDate'] ?? null,
                    'author' => $fields['byline'] ?? null,
                    'category' => $item['sectionName'] ?? null,
                ];
            }
            return $articles;
        }
        return [];
    }
}
