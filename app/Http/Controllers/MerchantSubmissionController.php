<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MerchantSubmission;

class MerchantSubmissionController extends Controller
{
    /**
     * Display a listing of the merchant submissions.
     */
    public function index()
    {
        $submissions = MerchantSubmission::with('merchant')->get();
        return response()->json($submissions);
    }

    /**
     * Store a newly created merchant submission in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'merchant_id' => 'nullable|exists:merchants,id',
        ]);

        $submission = MerchantSubmission::create($validatedData);
        return response()->json($submission, 201);
    }

    /**
     * Display the specified merchant submission.
     */
    public function show($id)
    {
        $submission = MerchantSubmission::with('merchant')->findOrFail($id);
        return response()->json($submission);
    }

    /**
     * Update the specified merchant submission in storage.
     */
    public function update(Request $request, $id)
    {
        $submission = MerchantSubmission::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'merchant_id' => 'nullable|exists:merchants,id',
        ]);

        $submission->update($validatedData);
        return response()->json($submission);
    }

    /**
     * Remove the specified merchant submission from storage.
     */
    public function destroy($id)
    {
        $submission = MerchantSubmission::findOrFail($id);
        $submission->delete();
        return response()->json(['message' => 'Merchant submission deleted successfully']);
    }
}
