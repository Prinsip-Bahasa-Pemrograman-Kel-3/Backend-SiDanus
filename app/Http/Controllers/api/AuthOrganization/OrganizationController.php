<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use Illuminate\Http\Request;
use App\Helpers\APIFormatter;
use Illuminate\Support\Facades\Log;

class OrganizationController extends Controller
{
    /**
     * Retrieve all organizations.
     */
    public function index()
    {
        try {
            $organizations = Organization::all();
            return APIFormatter::createAPI(200, 'Data retrieved successfully', $organizations);
        } catch (\Exception $e) {
            Log::error('Error fetching organizations:', ['error' => $e->getMessage()]);
            return APIFormatter::createAPI(500, 'An error occurred while retrieving data');
        }
    }

    /**
     * Create a new organization.
     */
    public function store(Request $request)
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
                'password' => $request->input('password'), // Automatically hashed via mutator
            ]);

            return APIFormatter::createAPI(201, 'Organization created successfully', $organization);
        } catch (\Exception $e) {
            Log::error('Error creating organization:', ['error' => $e->getMessage()]);
            return APIFormatter::createAPI(500, 'An error occurred while creating the organization');
        }
    }

    /**
     * Retrieve a single organization by ID.
     */
    public function show($id)
    {
        try {
            $organization = Organization::findOrFail($id);
            return APIFormatter::createAPI(200, 'Data retrieved successfully', $organization);
        } catch (\Exception $e) {
            Log::error('Error fetching organization:', ['error' => $e->getMessage()]);
            return APIFormatter::createAPI(404, 'Organization not found');
        }
    }

    /**
     * Update an existing organization by ID.
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'sometimes|string|max:255',
                'email' => 'sometimes|email|unique:organizations,email,' . $id,
                'password' => 'sometimes|string|min:8',
            ]);

            $organization = Organization::findOrFail($id);

            $organization->update($request->only(['name', 'email', 'password']));

            return APIFormatter::createAPI(200, 'Organization updated successfully', $organization);
        } catch (\Exception $e) {
            Log::error('Error updating organization:', ['error' => $e->getMessage()]);
            return APIFormatter::createAPI(500, 'An error occurred while updating the organization');
        }
    }

    /**
     * Delete an organization by ID.
     */
    public function destroy($id)
    {
        try {
            $organization = Organization::findOrFail($id);
            $organization->delete();
            return APIFormatter::createAPI(200, 'Organization deleted successfully');
        } catch (\Exception $e) {
            Log::error('Error deleting organization:', ['error' => $e->getMessage()]);
            return APIFormatter::createAPI(500, 'An error occurred while deleting the organization');
        }
    }
}
