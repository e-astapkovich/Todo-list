<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Тестовый админ №1
        User::factory()->admin()->create([
            'name' => 'Admin-1',
            'email' => 'admin-1@example.com',
        ]);

        // Тестовый админ №2
        User::factory()->admin()->create([
            'name' => 'Admin-2',
            'email' => 'admin-2@example.com',
        ]);

        // Тестовый пользователь №1
        User::factory()->create([
            'name' => 'User-1',
            'email' => 'user-1@example.com',
        ]);

        // Тестовый пользователь №2
        User::factory()->create([
            'name' => 'User-2',
            'email' => 'user-2@example.com',
        ]);

        // Случайные пользователи
        User::factory(10)->create();
    }
}
