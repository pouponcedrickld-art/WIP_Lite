<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    $roles = Role::all();

    // 🔥 ADMIN UNIQUE
    $adminRole = $roles->firstWhere('name', 'admin');

    User::factory()->create([
        'email' => 'admin@test.com',
        'role_id' => $adminRole->id,
    ]);

    // 🔥 autres users SANS admin
    $otherRoles = $roles->where('name', '!=', 'admin')->values();

    User::factory(199)->create()->each(function ($user) use ($otherRoles) {
        $user->update([
            'role_id' => $otherRoles->random()->id,
        ]);
    });
}
}