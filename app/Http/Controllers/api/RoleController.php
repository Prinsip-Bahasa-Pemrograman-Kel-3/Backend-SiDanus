<?php

namespace App\Http\Controllers\api;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::with('students')->get();
        return response()->json($roles);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'requred|string|max:255'
        ]);

        $role = Role::create([
            'name' => $request->name
        ]);

        return response()->json([
            'message' => 'Role created successfully',
            'data' => $role
        ], 201);
    }

    public function show(string $id)
    {
        $role = Role::with('students')->find($id);

        if ($role) {
            return response()->json([
                'message' => 'Role not found'
            ]);
        }

        return response()->json($role);
    }

    public function update(Request $request, string $id)
    {
        $role = Role::find($id);

        if (!$role) {
            return response()->json([
                'message' => 'Roe not found'
            ]);

            $request->validate([
                'name' => 'required|string|max:255'
            ]);

            $role->update([
                'name' => $request->name
            ]);

            return response()->json([
                'message' => 'Role updated successfully',
                'data' => $role
            ]);
        }
    }

    public function destroy(string $id)
    {
        $role = Role::find($id);

        if (!$role) {
            return response()->json([
                'message' => 'Role not found'
            ]);

            $role->delete();

            return response()->json([
                'message' => 'Role deleted seccessfully'
            ]);
        }
    }
}
