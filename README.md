# News Aggregator Backend

A Laravel-based backend for aggregating news articles from multiple sources (NewsAPI, The Guardian, BBC News), storing them locally, and exposing them via clean API endpoints for frontend consumption.

---

## Features
- Fetches and stores articles from NewsAPI, The Guardian, and BBC News (RSS)
- Exposes RESTful API endpoints for articles, sources, categories, and authors
- Supports search, filtering, and pagination
- Easily extendable to add more sources
- Clean, maintainable, and production-ready codebase

---

## Setup Instructions

1. **Clone the repository**
2. **Install dependencies**
   ```bash
   composer install
   ```
3. **Copy and configure your environment file**
   ```bash
   cp .env.example .env
   # Edit .env and set your DB and API keys
   ```
4. **Set your API keys in `.env`:**
   ```env
   NEWSAPI_KEY=your_newsapi_key_here
   GUARDIAN_KEY=your_guardian_api_key_here
   ```
5. **Run migrations and seeders**
   ```bash
   php artisan migrate --seed
   ```
6. **Fetch articles manually**
   ```bash
   php artisan app:fetch-articles
   ```

---

## Scheduling Regular Fetches
To fetch articles automatically, add this to your `app/Console/Kernel.php`:
```php
protected function schedule(Schedule $schedule)
{
    $schedule->command('app:fetch-articles')->hourly();
}
```
And set up your server's cron to run Laravel's scheduler:
```bash
* * * * * cd /path/to/project && php artisan schedule:run >> /dev/null 2>&1
```

---

## API Endpoints

- `GET /api/articles` — List articles (supports `search`, `category_id`, `source_id`, `author_id`, `date`, pagination)
- `GET /api/sources` — List all news sources
- `GET /api/categories` — List all categories
- `GET /api/authors` — List all authors

**Example:**
```
GET /api/articles?search=climate&category_id=2&page=1
```

---

## Adding New Sources
- Create a new service in `app/Services/` that implements a `fetchArticles()` method returning normalized article arrays.
- Add the service to the fetch command.
- Add the source to the `sources` table (via seeder or manually).

---

## Environment Variables
- `NEWSAPI_KEY` — Your NewsAPI key
- `GUARDIAN_KEY` — Your Guardian Open Platform API key
- Database credentials as per Laravel standard

---

## License
MIT
