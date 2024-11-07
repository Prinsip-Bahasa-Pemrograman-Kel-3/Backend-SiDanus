<?php

namespace Database\Seeders;

use App\Models\Major;
use App\Models\Department;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MajorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Assuming 'Computer Science' department was created with id = 1
        $computerScienceDepartment = Department::where('name', 'Computer Science')->first();
        
        // Create majors related to 'Computer Science' department
        Major::create([
            'name' => 'Software Engineering',
            'department_id' => $computerScienceDepartment->id,
        ]);
        Major::create([
            'name' => 'Data Science',
            'department_id' => $computerScienceDepartment->id,
        ]);

        // Repeat for other departments
        $electricalEngineeringDepartment = Department::where('name', 'Electrical Engineering')->first();
        
        Major::create([
            'name' => 'Power Systems',
            'department_id' => $electricalEngineeringDepartment->id,
        ]);
        Major::create([
            'name' => 'Telecommunications',
            'department_id' => $electricalEngineeringDepartment->id,
        ]);
    }
}
