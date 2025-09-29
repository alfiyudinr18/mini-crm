<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = Role::firstOrCreate(['name' => 'user']);

        $user = User::firstOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'User Example',
                'password' => Hash::make('password'),
            ]
        );

        if (!$user->hasRole('user')) {
            $user->assignRole($role);
        }
    }
}
