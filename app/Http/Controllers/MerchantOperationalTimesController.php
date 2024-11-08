<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MerchantOperationalTimes;

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
        $operationalTime = MerchantOperationalTimes::with(['day', 'merchant'])->find($id);
        if (!$operationalTime) {
            return response()->json(['message' => 'Data not found'], 404);
        }
        return response()->json($operationalTime);
    }

    // Menambahkan data baru
    public function store(Request $request)
    {
        $request->validate([
            'day_id' => 'nullable|exists:days,id',
            'merchant_id' => 'nullable|exists:merchants,id',
        ]);

        $operationalTime = MerchantOperationalTimes::create($request->all());
        return response()->json($operationalTime, 201);
    }

    // Mengupdate data
    public function update(Request $request, $id)
    {
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
    }

    // Menghapus data
    public function destroy($id)
    {
        $operationalTime = MerchantOperationalTimes::find($id);
        if (!$operationalTime) {
            return response()->json(['message' => 'Data not found'], 404);
        }

        $operationalTime->delete();
        return response()->json(['message' => 'Data deleted successfully']);
    }
}
