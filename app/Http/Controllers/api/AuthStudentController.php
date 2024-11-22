<?php

namespace App\Http\Controllers\api;

use App\Models\User;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthStudentController extends Controller
{
    public function register(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
                'nim' => 'required|string|unique:students',
                'avatar' => 'nullable|string',
                // 'major_id' => 'nullable|exists:majors,id',
                // 'organization_id' => 'nullable|exists:organizations,id',
            ]);

            // Create user
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            // Create student
            $authStudent = Student::create([
                'nim' => $request->nim,
                'avatar' => $request->avatar,
                // 'major_id' => $request->major_id,
                // 'organization_id' => $request->organization_id,
                'user_id' => $user->id,
            ]);

            return response()->json([
                'message' => 'Student registered successfully',
                'user' => $user,
                'student' => $authStudent
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to register student',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function login(Request $request)
    {
        try {
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

            if (!$user->student) {
                return response()->json(['error' => 'User is not a student'], 403);
            }

            $token = $user->createToken('authToken')->plainTextToken;

            return response()->json([
                'message' => 'Login successful',
                'token' => $token,
                'user' => $user,
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'error' => 'Invalid credentials',
                'message' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to login',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        try {
            $request->user()->currentAccessToken()->delete();

            return response()->json([
                'message' => 'Logout successful'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to logout',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
