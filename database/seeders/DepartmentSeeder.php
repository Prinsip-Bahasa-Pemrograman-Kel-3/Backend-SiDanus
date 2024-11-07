<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Department::create(['name' => 'Computer Science']);
        Department::create(['name' => 'Electrical Engineering']);
        Department::create(['name' => 'Mechanical Engineering']);
    }
}
