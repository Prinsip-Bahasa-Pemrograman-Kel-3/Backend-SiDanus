<?php

namespace App\Http\Controllers\api;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controller;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::with([
            'major', 
            'organization', 
            'user'
        ])->get();

        return response()->json($students, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nim' => 'required|string|max:10|unique:students',
            'avatar' => 'nullable|string',
            // 'major_id' => 'required|exists:majors,id',
            // 'organization_id' => 'required|exists:organizations,id',
            'user_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $student = Student::create($request->all());
        return response()->json($student, 201);
    }

    public function show($id)
    {
        $student = Student::with([
            'major', 
            'organization', 
            'user'
        ])->find($id);

        if (!$student) {
            return response()->json([
                'error' => 'Student not found'
        ], 404);
        }

        return response()->json($student, 200);
    }

    public function update(Request $request, $id)
    {
        $student = Student::find($id);

        if (!$student) {
            return response()->json([
                'error' => 'Student not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'nim' => 'string|max:10|unique:students,nim,' . $id,
            'avatar' => 'nullable|string',
            'major_id' => 'exists:majors,id',
            'organization_id' => 'exists:organizations,id',
            'user_id' => 'exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $student->update($request->all());
        return response()->json($student, 200);
    }

    public function destroy($id)
    {
        $student = Student::find($id);

        if (!$student) {
            return response()->json([
                'error' => 'Student not found'
            ], 404);
        }

        $student->delete();
        return response()->json([
            'message' => 'Student deleted successfully'
        ], 200);
    }
}
