<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\AuthStudent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuntStudentController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'nim' => 'required|string|unique:students',
            'avatar' => 'nullable|string',
            'major_id' => 'nullable|exists:majors,id',
            'organization_id' => 'nullable|exists:organizations,id',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $authStudent = AuthStudent::create([
            'nim' => $request->nim,
            'avatar' => $request->avatar,
            'major_id' => $request->major_id,
            'organization_id' => $request->organization_id,
            'user_id' => $user->id,
        ]);

        return response()->json([
            'message' => 'Student registered successfully',
            'user' => $user,
            'student' => $authStudent
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'token' => $token,
            'user' => $user,
        ], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logout successful'
        ]);
    }
}
