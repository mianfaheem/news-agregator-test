<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class BbcNewsService
{
    protected string $feedUrl = 'https://feeds.bbci.co.uk/news/rss.xml';

    /**
     * Fetch articles from BBC News RSS feed.
     * @return array
     */
    public function fetchArticles(): array
    {
        $response = Http::get($this->feedUrl);
        if (!$response->successful()) {
            return [];
        }
        $xml = simplexml_load_string($response->body());
        if (!$xml || !isset($xml->channel->item)) {
            return [];
        }
        $articles = [];
        foreach ($xml->channel->item as $item) {
            $articles[] = [
                'title' => (string) $item->title,
                'description' => (string) $item->description,
                'content' => (string) $item->description, // RSS usually doesn't have full content
                'url' => (string) $item->link,
                'image_url' => isset($item->enclosure) ? (string) $item->enclosure['url'] : null,
                'published_at' => isset($item->pubDate) ? date('Y-m-d H:i:s', strtotime((string) $item->pubDate)) : null,
                'author' => null, // BBC RSS does not provide author
                'category' => isset($item->category) ? (string) $item->category : null,
            ];
        }
        return $articles;
    }
}
