<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'email' => 'admin@example.com',
                'password' => bcrypt('password'),
                'role_id' => Role::where('name', 'admin')->first()->id,
            ],
            [
                'email' => 'jean.dupont@example.com',
                'password' => bcrypt('password'),
                'role_id' => Role::where('name', 'cp')->first()->id,
            ],
            [
                'email' => 'marie.martin@example.com',
                'password' => bcrypt('password'),
                'role_id' => Role::where('name', 'cp')->first()->id,
            ],
            [
                'email' => 'pierre.durand@example.com',
                'password' => bcrypt('password'),
                'role_id' => Role::where('name', 'sup')->first()->id,
            ],
            [
                'email' => 'sophie.lefebvre@example.com',
                'password' => bcrypt('password'),
                'role_id' => Role::where('name', 'tc')->first()->id,
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
