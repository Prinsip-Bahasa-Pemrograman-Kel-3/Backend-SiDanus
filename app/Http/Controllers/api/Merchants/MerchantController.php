<?php

namespace App\Http\Controllers\api\Merchants;

use App\Models\Merchant;
use Illuminate\Http\Request;
use App\Models\MerchantSubmission;
use Illuminate\Routing\Controller;

class MerchantController extends Controller
{
    public function index()
    {
        $merchants = Merchant::all();
        return response()->json($merchants);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'business_phone' => 'nullable|string|max:15',
            'business_email' => 'nullable|email|max:255',
            'id_card_image' => 'required|string',
            'avatar' => 'nullable|string',
            'student_id' => 'nullable|exists:students,id',
            'organization_id' => 'nullable|exists:organizations,id',
            'event_id' => 'nullable|exists:events,id',
        ]);
    }

    public function show(Merchant $merchant)
    {
        return response()->json($merchant);
    }

    public function update(Request $request, Merchant $merchant)
    {
        $validatedData = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'business_phone' => 'nullable|string|max:15',
            'business_email' => 'nullable|email|max:255',
            'id_card_image' => 'sometimes|required|string',
            'avatar' => 'nullable|string',
            'student_id' => 'nullable|exists:students,id',
            'organization_id' => 'nullable|exists:organizations,id',
            'event_id' => 'nullable|exists:events,id',
        ]);

        $merchant->update($validatedData);

        return response()->json([
            'message' => 'Merchant updated successfully', 
            'merchant' => $merchant
        ]);
    }

    public function destroy(MerchantSubmission $merchantSubmission)
    {
        $merchantSubmission->delete();

        return response()->json([
            'message' => 'Merchant Submission deleted successfully'
        ]);
    }
}
