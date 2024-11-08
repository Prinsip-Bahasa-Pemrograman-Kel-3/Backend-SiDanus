<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Menonaktifkan foreign key checks sementara
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Menghapus semua data lama di tabel users
        User::truncate();

        // Menambahkan data secara manual
        User::create([
            'name' => 'Test User 1',
            'email' => 'test1@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        ]);

        User::create([
            'name' => 'Test User 2',
            'email' => 'test2@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password123'),
            'remember_token' => Str::random(10),
        ]);

        // Anda bisa menambahkan lebih banyak data sesuai kebutuhan
        User::create([
            'name' => 'Test User 3',
            'email' => 'test3@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password456'),
            'remember_token' => Str::random(10),
        ]);

        // Jika Anda menggunakan `insertOrIgnore`, Anda bisa menambahkan data seperti ini
        User::insertOrIgnore([
            [
                'name' => 'Test User Ignore',
                'email' => 'test@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password123'),
                'remember_token' => Str::random(10),
            ]
        ]);

        // Menggunakan upsert untuk memperbarui data jika email sudah ada
        User::upsert([
            [
                'name' => 'Test User Updated',
                'email' => 'test@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('newpassword123'),
                'remember_token' => Str::random(10),
            ]
        ], ['email'], ['name', 'password']);
    }
}
