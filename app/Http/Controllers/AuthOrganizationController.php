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
     * Display a listing of all organizations.
     */
    public function index()
    {
        // Ambil semua data organisasi
        $organizations = AuthOrganization::all();
        return response()->json($organizations);
    }

    /**
     * Store a newly created organization in storage.
     */
    public function store(Request $request)
    {
        // Validasi input untuk data organisasi baru
        $request->validate([
            'name' => 'required|string|unique:auth_organizations',
            'email' => 'required|email|unique:auth_organizations',
            'password' => 'required|string|min:6',
            'description' => 'nullable|string',
        ]);

        // Membuat organisasi baru
        $organization = new AuthOrganization();
        $organization->name = $request->input('name');
        $organization->email = $request->input('email');
        $organization->password = Hash::make($request->input('password')); // Enkripsi password
        $organization->description = $request->input('description');
        $organization->save();

        return response()->json([
            'success' => true,
            'message' => 'Organisasi berhasil dibuat.',
            'organization' => $organization,
        ], 201);
    }

    /**
     * Display the specified organization by ID.
     */
    public function show($id)
    {
        // Cari organisasi berdasarkan ID
        $organization = AuthOrganization::find($id);
        
        if ($organization) {
            return response()->json($organization);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Organisasi tidak ditemukan.'
            ], 404);
        }
    }

    /**
     * Update the specified organization in storage.
     */
    public function update(Request $request, $id)
    {
        // Validasi input untuk update data organisasi
        $request->validate([
            'name' => 'string|unique:auth_organizations,name,' . $id,
            'email' => 'email|unique:auth_organizations,email,' . $id,
            'password' => 'string|min:6',
            'description' => 'nullable|string',
        ]);

        // Cari organisasi berdasarkan ID
        $organization = AuthOrganization::find($id);

        if ($organization) {
            // Update data organisasi
            $organization->name = $request->input('name', $organization->name);
            $organization->email = $request->input('email', $organization->email);
            if ($request->has('password')) {
                $organization->password = Hash::make($request->input('password'));
            }
            $organization->description = $request->input('description', $organization->description);
            $organization->save();

            return response()->json([
                'success' => true,
                'message' => 'Organisasi berhasil diperbarui.',
                'organization' => $organization,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Organisasi tidak ditemukan.'
            ], 404);
        }
    }

    /**
     * Remove the specified organization from storage.
     */
    public function destroy($id)
    {
        // Cari organisasi berdasarkan ID
        $organization = AuthOrganization::find($id);

        if ($organization) {
            // Hapus organisasi
            $organization->delete();

            return response()->json([
                'success' => true,
                'message' => 'Organisasi berhasil dihapus.'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Organisasi tidak ditemukan.'
            ], 404);
        }
    }
}
