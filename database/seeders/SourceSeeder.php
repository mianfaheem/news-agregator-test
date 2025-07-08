<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('sources')->insert([
            [
                'name' => 'NewsAPI',
                'api_identifier' => 'newsapi',
                'url' => 'https://newsapi.org/',
                'description' => 'A comprehensive API for accessing news articles from various sources.'
            ],
            [
                'name' => 'The Guardian',
                'api_identifier' => 'guardian',
                'url' => 'https://open-platform.theguardian.com/',
                'description' => 'API for accessing articles from The Guardian newspaper.'
            ],
            [
                'name' => 'BBC News',
                'api_identifier' => 'bbc',
                'url' => 'https://www.bbc.co.uk/news',
                'description' => 'Trusted news from BBC News.'
            ],
        ]);
    }
}
