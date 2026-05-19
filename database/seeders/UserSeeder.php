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

        User::create([
            'name' => 'Admin Principal',
            'email' => 'admin@resto.com',
            'password' => Hash::make('password'),
            'role_id' => $adminRole->id
        ]);

        User::create([
            'name' => 'Jean Serveur',
            'email' => 'serveur@resto.com',
            'password' => Hash::make('password'),
            'role_id' => $serveurRole->id
        ]);
       
        // Crée un user normal (client)
        User::create([
            'name' => 'Client Test',
            'email' => 'client@test.com',
            'password' => Hash::make('password'),
            'role_id' => $serveurRole->id  // par défaut serveur pour tester
        ]);
    }
}
