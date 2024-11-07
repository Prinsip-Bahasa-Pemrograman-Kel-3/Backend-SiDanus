<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Test User 1',
            'email' => 'test1@example.com',
            'password' => Hash::make('password'),
            'role_id' => 2,
        ]);

        User::create([
            'name' => 'Test User 2',
            'email' => 'test2@example.com',
            'password' => Hash::make('password'),
            'role_id' => 1,
        ]);

    }
}
