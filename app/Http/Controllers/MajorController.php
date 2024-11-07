<?php

namespace App\Http\Controllers;

use App\Models\Major;
use Illuminate\Http\Request;

class MajorController extends Controller
{
    public function index()
    {
        $majors = Major::with('departement', 'students')->get();
        return response()->json($majors);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'department_id' => 'nullable|exists:departments,id',
        ]);

        $major = Major::create([
            'name' => $request->name,
            'department_id' => $request->department_id,
        ]);

        return response()->json([
            'message' => 'Major created successfully',
            'data' => $major
        ], 201);
    }

    public function show(string $id)
    {
        $major = Major::with('departement', 'students')->find($id); 

        if (!$major) {
            return response()->json([
                'message' => 'Major not found'
            ], 404);
        }

        return response()->json($major);
    }

    public function update(Request $request, string $id)
    {
        $major = Major::find($id);

        if (!$major) {
            return response()->json([
                'message' => 'Major not found'
            ], 404);
        }

        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'department_id' => 'nullable|exists:departments,id',
        ]);

        $major->name = $request->name ?? $major->name;
        $major->department_id = $request->department_id ?? $major->department_id;
        $major->save();

        return response()->json([
            'message' => 'Major updated successfully',
            'data' => $major
        ]);
    }

    public function destroy(string $id)
    {
        $major = Major::find($id);

        if (!$major) {
            return response()->json([
                'message' => 'Major not found'
            ], 404);
        }

        $major->delete();

        return response()->json([
            'message' => 'Major deleted successfully'
        ]);
    }
}
