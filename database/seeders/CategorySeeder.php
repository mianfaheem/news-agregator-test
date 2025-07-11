<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('categories')->insert([
            ['name' => 'World'],
            ['name' => 'Business'],
            ['name' => 'Technology'],
            ['name' => 'Sports'],
            ['name' => 'Entertainment'],
            ['name' => 'Health'],
            ['name' => 'Science'],
        ]);
    }
}
