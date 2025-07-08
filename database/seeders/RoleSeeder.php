<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'super-admin',
                'guard_name' => 'api',
                'added_by' => 1, // Assuming ID 1 is your first admin
            ],
            [
                'name' => 'user',
                'guard_name' => 'api',
                'added_by' => 1,
            ],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
} 