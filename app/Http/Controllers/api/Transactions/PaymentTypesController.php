<?php

namespace App\Http\Controllers\api\Transactions;

use Illuminate\Http\Request;
use App\Helpers\APIFormatter;
use App\Models\PaymentTypes;
use Illuminate\Support\Facades\DB;

class PaymentTypesController
{
    public function index()
    {
        try {
            $paymentTypes = PaymentTypes::all();
            if ($paymentTypes->isEmpty()) {
                return APIFormatter::createAPI(200, 'success', 'Payment Types not found', null);
            }
            return APIFormatter::createAPI(200, 'success', 'Payment Types found', $paymentTypes);
        } catch (\Throwable $th) {
            return APIFormatter::createAPI(400, 'fail', 'Failed to get payment types', $th->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $paymentType = PaymentTypes::findOrFail($id);
            if (!$paymentType) {
                return APIFormatter::createAPI(200, 'success', 'Payment Type not found', null);
            }
            return APIFormatter::createAPI(200, 'success', 'Payment Type found', $paymentType);
        } catch (\Throwable $th) {
            return APIFormatter::createAPI(400, 'fail', 'Failed to get payment type', $th->getMessage());
        }
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'name' => 'required|string'
            ]);
            $paymentType = PaymentTypes::create([
                'name' => $request->name
            ]);
            DB::commit();
            return APIFormatter::createAPI(200, 'success', 'Payment Type created', $paymentType);
        } catch (\Throwable $th) {
            DB::rollBack();
            return APIFormatter::createAPI(400, 'fail', 'Failed to create payment type', $th->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $paymentType = PaymentTypes::findOrFail($id);
            if (!$paymentType) {
                return APIFormatter::createAPI(200, 'success', 'Payment Type not found', null);
            }
            $request->validate([
                'name' => 'required|string'
            ]);
            $paymentType->update([
                'name' => $request->name
            ]);
            DB::commit();
            return APIFormatter::createAPI(200, 'success', 'Payment Type updated', $paymentType);
        } catch (\Throwable $th) {
            DB::rollBack();
            return APIFormatter::createAPI(400, 'fail', 'Failed to update payment type', $th->getMessage());
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $paymentType = PaymentTypes::findOrFail($id);
            if (!$paymentType) {
                return APIFormatter::createAPI(200, 'success', 'Payment Type not found', null);
            }
            $paymentType->delete();
            DB::commit();
            return APIFormatter::createAPI(200, 'success', 'Payment Type deleted', null);
        } catch (\Throwable $th) {
            DB::rollBack();
            return APIFormatter::createAPI(400, 'fail', 'Failed to delete payment type', $th->getMessage());
        }
    }
}
