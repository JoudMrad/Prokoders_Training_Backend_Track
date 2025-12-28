<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        User::truncate();

        User::create([
            'name' => 'joudAdmin',
            'email' => 'joudmrad@gmail.com',
            'password' => Hash::make('admin123'),
            'is_admin' => true,
        ]);
        
        User::create([
            'name' => 'Test User',
            'email' => 'user@example.com',
            'password' => Hash::make('password123'),
            'is_admin' => false,
        ]);

        echo "Users created successfully!\n";
        echo "Admin: joudmrad@gmail.com / admin123\n";
        echo "User: user@example.com / password123\n";
    }
}