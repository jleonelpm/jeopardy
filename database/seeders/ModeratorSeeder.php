<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ModeratorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear un moderador de prueba
        User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => Hash::make('password'),
                'role' => 'moderador',
                'email_verified_at' => now(),
            ]
        );

        // Crear moderadores adicionales de ejemplo
        User::factory()
            ->count(2)
            ->moderator()
            ->create();
    }
}
