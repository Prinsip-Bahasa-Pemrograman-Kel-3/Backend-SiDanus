<?php

namespace App\Http\Controllers\api\AuthOrganization;

use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Helpers\APIFormatter;
use Illuminate\Routing\Controller;

class AuthOrganizationController extends Controller
{
    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required|string',
            ]);

            $organization = Organization::where('email', $request->input('email'))->first();

            if (!$organization || !Hash::check($request->input('password'), $organization->password)) {
                return APIFormatter::createAPI(401, 'Invalid credentials');
            }

            $token = $organization->createToken($request->email, ['organization'])->plainTextToken;

            return APIFormatter::createAPI(200, 'Login successful', ['token' => $token]);
        } catch (\Exception $e) {
            return APIFormatter::createAPI(500, 'Login failed', ['error' => $e->getMessage()]);
        }
    }

    public function logout(Request $request)
    {
        try {
            $request->user()->currentAccessToken()->delete();

            return APIFormatter::createAPI(200, 'Logout successful');
        } catch (\Exception $e) {
            return APIFormatter::createAPI(500, 'Logout failed', ['error' => $e->getMessage()]);
        }
    }
}
