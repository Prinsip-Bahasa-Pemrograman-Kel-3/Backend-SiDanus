<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AuthStudent;

class AuthStudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AuthStudent::create([
            'student_id' => 1, // Replace with actual student ID if you have a relationship
            'token' => 'dummy_token_123',
        ]);
    }
}
