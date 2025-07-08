<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            SourceSeeder::class,
            CategorySeeder::class,
        ]);

        // Create admin user first
        $admin = User::create([
            'name' => 'Super Admin',
            'first_name' => 'Super',
            'last_name' => 'Admin',
            'password' => Hash::make('12345678'),
            'email' => 'admin@gmail.com',
        ]);

        // Then run role seeder
        $this->call(RoleSeeder::class);

        // Assign super-admin role to admin user with API guard
        $admin->assignRole(['super-admin']);
    }
}
