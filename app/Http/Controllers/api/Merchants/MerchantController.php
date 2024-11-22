<?php

namespace App\Http\Controllers\api\Merchants;

use App\Models\Merchant;
use Illuminate\Http\Request;
use App\Helpers\APIFormatter;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class MerchantController extends Controller
{
    // Mengambil daftar merchants dengan filtering
    public function index(Request $request)
{
    try {
        $query = Merchant::query();

        // Filter berdasar parameter
        if ($request->has('name')) {
            $query->where('name', 'like', '%' . $request->input('name') . '%');
        }
        if ($request->has('organization_id')) {
            $query->where('organization_id', $request->input('organization_id'));
        }
        if ($request->has('event_id')) {
            $query->where('event_id', $request->input('event_id'));
        }

        // Tambahkan logika pencarian global
        if ($request->has('search')) {
            $searchTerm = $request->input('search');
            $query->where(function ($query) use ($searchTerm) {
                $query->where('name', 'like', "%{$searchTerm}%")
                      ->orWhere('description', 'like', "%{$searchTerm}%");
            });
        }

        $merchants = $query->get();

        if ($merchants->isEmpty()) {
            return APIFormatter::createAPI(200, 'success', 'No merchants found', null);
        }
        return APIFormatter::createAPI(200, 'success', 'Merchants found', $merchants);
    } catch (\Throwable $e) {
        return APIFormatter::createAPI(500, 'error', 'Failed to get merchants', $e->getMessage());
    }
}


    // Mencari merchants berdasarkan keyword
    public function search(Request $request)
    {
        $request->validate([
            'search' => 'nullable|string|max:255',
        ]);

        $searchTerm = $request->input('search');

        $merchants = Merchant::query()
            ->when($searchTerm, function ($query, $searchTerm) {
                return $query->where('name', 'LIKE', "%{$searchTerm}%")
                             ->orWhere(function ($query) use ($searchTerm) {
                                 if (Schema::hasColumn('merchants', 'description')) {
                                     $query->orWhere('description', 'LIKE', "%{$searchTerm}%");
                                 }
                             });
            })
            ->get();

        if ($merchants->isEmpty()) {
            return response()->json([
                'metadata' => [
                    'code' => 200,
                    'status' => 'success',
                    'message' => 'No merchants found',
                ],
                'data' => null,
            ]);
        }

        return response()->json([
            'metadata' => [
                'code' => 200,
                'status' => 'success',
                'message' => 'Merchants found',
            ],
            'data' => $merchants,
        ]);
    }

    // Menambahkan merchant baru
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'business_phone' => 'nullable|string|max:15',
                'business_email' => 'nullable|string|max:255',
                'id_card_image' => 'required|string',
                'avatar' => 'nullable|string',
                // 'student_id' => 'nullable|exists:students,id',
                // 'organization_id' => 'nullable|exists:organizations,id',
                // 'event_id' => 'nullable|exists:events,id'
            ]);

            $merchant = Merchant::create([
                'name' => $request->name,
                'description' => $request->description,
                'business_phone' => $request->business_phone,
                'business_email' => $request->business_email,
                'id_card_image' => $request->id_card_image,
                'avatar' => $request->avatar,
                // 'student_id' => $request-> student_id,
                // 'organization_id' => $request-> rganization_id,
                // 'event_id' => $request-> event_id,
            ]);

            DB::commit();

            return APIFormatter::createAPI(201, 'success', 'Merchant created', $merchant);
        } catch (\Throwable $e) {
            DB::rollBack();
            return APIFormatter::createAPI(500, 'error', 'Failed to create merchant', $e->getMessage());
        }
    }

    // Menampilkan detail merchant
    public function show($id)
    {
        try {
            $merchant = Merchant::findOrFail($id);
            return APIFormatter::createAPI(200, 'success', 'Merchant found', $merchant);
        } catch (\Throwable $e) {
            return APIFormatter::createAPI(500, 'error', 'Failed to get merchant', $e->getMessage());
        }
    }

    // Memperbarui data merchant
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $validatedData = $request->validate([
                'name' => 'sometimes|required|string|max:255',
                'description' => 'sometimes|required|string',
                'business_phone' => 'nullable|string|max:15',
                'business_email' => 'nullable|email|max:255',
                'id_card_image' => 'sometimes|required|string',
                'avatar' => 'nullable|string',
                // 'student_id' => 'nullable|exists:students,id',
                // 'organization_id' => 'nullable|exists:organizations,id',
                // 'event_id' => 'nullable|exists:events,id'
            ]);

            $merchant = Merchant::findOrFail($id);
            $merchant->update($validatedData);
            DB::commit();

            return APIFormatter::createAPI(200, 'success', 'Merchant updated', $merchant);
        } catch (\Throwable $e) {
            DB::rollBack();
            return APIFormatter::createAPI(500, 'error', 'Failed to update merchant', $e->getMessage());
        }
    }

    // Menghapus merchant
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $merchant = Merchant::findOrFail($id);
            $merchant->delete();
            DB::commit();

            return APIFormatter::createAPI(200, 'success', 'Merchant deleted', null);
        } catch (\Throwable $e) {
            DB::rollBack();
            return APIFormatter::createAPI(500, 'error', 'Failed to delete merchant', $e->getMessage());
        }
    }

    // Menampilkan transaksi terkait merchant
    public function transactions($id)
    {
        try {
            $merchant = Merchant::findOrFail($id);
            $transactions = $merchant->transactions;

            if ($transactions->isEmpty()) {
                return APIFormatter::createAPI(200, 'success', 'No transactions found for this merchant', null);
            }

            return APIFormatter::createAPI(200, 'success', 'Transactions found', $transactions);
        } catch (\Throwable $e) {
            return APIFormatter::createAPI(500, 'error', 'Failed to get transactions', $e->getMessage());
        }
    }
}
