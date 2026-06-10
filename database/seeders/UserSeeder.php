<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::where('name', 'admin')->first();
        $serveurRole = Role::where('name', 'serveur')->first();
        $cuisineRole = Role::where('name', 'cuisine')->first();
        $clientRole = Role::where('name', 'client')->first();

        // Admin
        User::create([
            'name' => 'Admin Principal',
            'email' => 'admin@resto.com',
            'password' => Hash::make('password'),
            'role_id' => $adminRole->id
        ]);

        // Serveur
        User::create([
            'name' => 'Jean Serveur',
            'email' => 'serveur@resto.com',
            'password' => Hash::make('password'),
            'role_id' => $serveurRole->id
        ]);

        // Cuisine
        User::create([
            'name' => 'Chef Cuisine',
            'email' => 'cuisine@resto.com',
            'password' => Hash::make('password'),
            'role_id' => $cuisineRole->id
        ]);

        // Client (NOUVEAU)
        User::create([
            'name' => 'Client Test',
            'email' => 'client@test.com',
            'password' => Hash::make('password'),
            'role_id' => $clientRole->id
        ]);
    }
}