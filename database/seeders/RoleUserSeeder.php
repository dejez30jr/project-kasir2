<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RoleUserSeeder extends Seeder
{
    public function run(): void
    {
        if (!User::where('email','admin@example.com')->exists()) {
            User::create([
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'role' => 'admin',
                'password' => Hash::make('password'),
            ]);
        }
        if (!User::where('email','cashier@example.com')->exists()) {
            User::create([
                'name' => 'Kasir',
                'email' => 'cashier@example.com',
                'role' => 'cashier',
                'password' => Hash::make('password'),
            ]);
        }
    }
}
