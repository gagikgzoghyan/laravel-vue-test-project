<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    private array $roles = [
        [
            'name' => Role::ADMIN,
            'display_name' => 'Admin',
            'guard_name' => 'web'
        ],
        [
            'name' => Role::USER,
            'display_name' => 'User',
            'guard_name' => 'web'
        ],
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->roles as $role) {
            Role::create($role);
        }
    }
}
