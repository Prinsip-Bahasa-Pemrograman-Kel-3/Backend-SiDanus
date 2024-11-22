<?php

namespace App\Http\Controllers\api\Merchants;

use Illuminate\Http\Request;
use App\Models\MerchantOperationalTimes;
use Illuminate\Routing\Controller;

class MerchantOperationalTimesController extends Controller
{
    // Menampilkan semua data
    public function index()
    {
        $operationalTimes = MerchantOperationalTimes::with(['day', 'merchant'])->get();
        return response()->json($operationalTimes);
    }

    // Menampilkan data berdasarkan ID
    public function show($id)
    {
        try {
            $operationalTime = MerchantOperationalTimes::with(['day', 'merchant'])->findOrFail($id);
            return response()->json($operationalTime);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['message' => 'Data not found'], 404);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Error occurred while retrieving operational time',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    

    // Menambahkan data baru
    public function store(Request $request)
    {
        try {
            $request->validate([
                'day_id' => 'nullable|exists:days,id',
                'merchant_id' => 'nullable|exists:merchants,id',
            ]);

            $operationalTime = MerchantOperationalTimes::create($request->all());
            return response()->json($operationalTime, 201);

        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Error occurred while creating operational time',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // Mengupdate data
    public function update(Request $request, $id)
    {
        try {
            $operationalTime = MerchantOperationalTimes::find($id);
            if (!$operationalTime) {
                return response()->json(['message' => 'Data not found'], 404);
            }
    
            $request->validate([
                'day_id' => 'nullable|exists:days,id',
                'merchant_id' => 'nullable|exists:merchants,id',
            ]);
    
            $operationalTime->update($request->all());
            return response()->json($operationalTime);
    
        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Error occurred while updating operational time',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    
    // Menghapus data
    public function destroy($id)
    {
        try {
            $operationalTime = MerchantOperationalTimes::find($id);
            if (!$operationalTime) {
                return response()->json(['message' => 'Data not found'], 404);
            }
    
            $operationalTime->delete();
            return response()->json(['message' => 'Data deleted successfully']);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Error occurred while deleting operational time',
                'error' => $e->getMessage(),
            ], 500);
        }
    }    
}
