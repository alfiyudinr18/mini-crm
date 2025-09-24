<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        $user = User::firstOrCreate(
            ['email' => 'developer@idsolutions.id'],
            [
                'name' => 'Developer',
                'password' => Hash::make('dev-root'),
                'email_verified_at' => now(),
            ]
        );

        if (!$user->hasRole('admin')) {
            $user->assignRole($adminRole);
        }
    }
}
