<?php

namespace App\Http\Controllers\api;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::with('students')->get();
        return response()->json($departments);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $department = Department::create([
            'name' => $request->name,
        ]);

        return response()->json([
            'message' => 'Department created successfully',
            'data' => $department
        ], 201);
    }

    public function show(string $id)
    {
        $department = Department::with('students')->find($id);

        if (!$department) {
            return response()->json([
                'message' => 'Department not found'
            ], 404);
        }

        return response()->json($department);
    }

    public function update(Request $request, string $id)
    {
        $department = Department::find($id);

        if (!$department) {
            return response()->json([
                'message' => 'Department not found'
            ], 404);
        }

        $request->validate([
            'name' => 'sometimes|required|string|max:255',
        ]);

        $department->name = $request->name ?? $department->name;
        $department->save();

        return response()->json([
            'message' => 'Department updated successfully',
            'data' => $department
        ]);
    }

    public function destroy(string $id)
    {
        $department = Department::find($id);

        if (!$department) {
            return response()->json([
                'message' => 'Department not found'
            ], 404);
        }

        $department->delete();

        return response()->json([
            'message' => 'Department deleted successfully'
        ]);
    }
}
