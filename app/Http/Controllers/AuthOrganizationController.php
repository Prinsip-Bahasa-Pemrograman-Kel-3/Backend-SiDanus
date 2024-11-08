<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AuthOrganization;
use Illuminate\Support\Facades\Hash;

class AuthOrganizationController extends Controller
{
    /**
     * Login method for organization using Email and Password.
     */
    public function login(Request $request)
    {
        // Validasi input untuk 'email' dan 'password'
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Cari organisasi berdasarkan email
        $organization = User::where('email', $request->input('email'))->first();

        // Cek apakah organisasi ditemukan dan password cocok
        if ($organization && Hash::check($request->input('password'), $organization->password)) {
            // Jika organisasi ditemukan dan password cocok, kirim respons sukses
            $token = $organization->createToken($request->email, ['organization'])->plainTextToken;

            if ($token) {
                return APIFormatter::createAPI(200, "Success", $token);
            } else {
                return APIFormatter::createAPI(400, 'Failed');
            }
        } else {
            return APIFormatter::createAPI(500, 'Error');
        }
    }

    /**
     * Logout method for organization.
     */
    public function logout(Request $request)
    {
        // Menghapus token autentikasi organisasi saat ini
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logout berhasil.',
        ], 200);
    }

}
