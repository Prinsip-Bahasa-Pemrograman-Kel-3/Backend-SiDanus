<?php

namespace App\Http\Controllers\api\AuthOrganization;

use App\Models\Organization;
use Illuminate\Http\Request;
use App\Helpers\APIFormatter;
use Illuminate\Routing\Controller;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:organizations,email',
                'password' => 'required|string|min:8',
            ]);

            $organization = Organization::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => bcrypt($request->input('password')), // Hash password
            ]);

            return APIFormatter::createAPI(200, 'Registration successful', $organization);
        } catch (\Exception $e) {
            return APIFormatter::createAPI(500, 'Registration failed', ['error' => $e->getMessage()]);
        }
    }
}
