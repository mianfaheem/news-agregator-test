<?php
Repositories/ArticleRepository.php
namespace App\Repositories;

use App\Models\Article;

class ArticleRepository
{
    public function filter($filters)
    {
        $query = Article::query();

        if (!empty($filters['search'])) {
            $query->where('title', 'like', '%' . $filters['search'] . '%');
        }
        if (!empty($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }
        if (!empty($filters['source_id'])) {
            $query->where('source_id', $filters['source_id']);
        }
        if (!empty($filters['author_id'])) {
            $query->where('author_id', $filters['author_id']);
        }
        if (!empty($filters['date'])) {
            $query->whereDate('published_at', $filters['date']);
        }

        return $query->latest()->paginate(20);
    }
}