<?php

namespace App\Http\Controllers\api\Merchants;

use Illuminate\Http\Request;
use App\Models\MerchantSubmission;
use Illuminate\Routing\Controller;

class MerchantSubmissionController extends Controller
{
    public function index()
    {
        try {
            $submissions = MerchantSubmission::with('merchant')->get();
            return response()->json($submissions);
        } catch (\Throwable $e) {
            return response()->json([
                'error' => 'Failed to retrieve submissions',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'merchant_id' => 'nullable|exists:merchants,id',
            ]);

            $submission = MerchantSubmission::create($validatedData);
            return response()->json($submission, 201);
        } catch (\Throwable $e) {
            return response()->json([
                'error' => 'Failed to create submission',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $submission = MerchantSubmission::with('merchant')->findOrFail($id);
            return response()->json($submission);
        } catch (\Throwable $e) {
            return response()->json([
                'error' => 'Failed to retrieve submission',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $submission = MerchantSubmission::findOrFail($id);

            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'merchant_id' => 'nullable|exists:merchants,id',
            ]);

            $submission->update($validatedData);
            return response()->json($submission);
        } catch (\Throwable $e) {
            return response()->json([
                'error' => 'Failed to update submission',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $submission = MerchantSubmission::findOrFail($id);
            $submission->delete();
            return response()->json([
                'message' => 'Merchant submission deleted successfully'
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'error' => 'Failed to delete submission',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
