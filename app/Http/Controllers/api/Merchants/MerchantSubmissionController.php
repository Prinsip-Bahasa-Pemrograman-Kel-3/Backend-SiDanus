<?php

namespace App\Http\Controllers\api\Merchants;

use Illuminate\Http\Request;
use App\Models\MerchantSubmission;
use Illuminate\Routing\Controller;

class MerchantSubmissionController extends Controller
{
    public function index()
    {
        $submissions = MerchantSubmission::with('merchant')->get();
        return response()->json($submissions);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'merchant_id' => 'nullable|exists:merchants,id',
        ]);

        $submission = MerchantSubmission::create($validatedData);
        return response()->json($submission, 201);
    }

    public function show($id)
    {
        $submission = MerchantSubmission::with('merchant')->findOrFail($id);
        return response()->json($submission);
    }

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

    public function destroy($id)
    {
        $submission = MerchantSubmission::findOrFail($id);
        $submission->delete();
        return response()->json([
            'message' => 'Merchant submission deleted successfully'
        ]);
    }
}
