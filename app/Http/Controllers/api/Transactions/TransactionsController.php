<?php

namespace App\Http\Controllers\api\Transactions;

use App\Models\Transactions;
use App\Helpers\APIFormatter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionsController
{
    public function index()
    {
        try {
            $transactions = Transactions::all();
            if ($transactions->isEmpty()) {
                return APIFormatter::createAPI(200, 'success', 'Transactions not found', null);
            }
            return APIFormatter::createAPI(200, 'success', 'Transactions found', $transactions);
        } catch (\Throwable $th) {
            return APIFormatter::createAPI(400, 'fail', 'Failed to get transactions', $th->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $transaction = Transactions::findOrFail($id);
            if (!$transaction) {
                return APIFormatter::createAPI(200, 'success', 'Transaction not found', null);
            }
            return APIFormatter::createAPI(200, 'success', 'Transaction found', $transaction);
        } catch (\Throwable $th) {
            return APIFormatter::createAPI(400, 'fail', 'Failed to get transaction', $th->getMessage());
        }
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'date' => 'required|date',
                'status' => 'required|string',
                'total_amount' => 'required|numeric',
                'merchant_id' => 'required|exists:merchants,id',
                'shipment_type_id' => 'required|exists:shipment_types,id',
                'payment_type_id' => 'required|exists:payment_types,id'
            ]);
            $transaction = Transactions::create([
                'date' => $request->date,
                'status' => $request->status,
                'total_amount' => $request->total_amount,
                'merchant_id' => $request->merchant_id,
                'shipment_type_id' => $request->shipment_type_id,
                'payment_type_id' => $request->payment_type_id
            ]);
            DB::commit();
            return APIFormatter::createAPI(200, 'success', 'Transaction created', $transaction);
        } catch (\Throwable $th) {
            DB::rollBack();
            return APIFormatter::createAPI(400, 'fail', 'Failed to create transaction', $th->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $transaction = Transactions::findOrFail($id);
            if (!$transaction) {
                return APIFormatter::createAPI(200, 'success', 'Transaction not found', null);
            }
            $request->validate([
                'date' => 'required|date',
                'status' => 'required|string',
                'total_amount' => 'required|numeric',
                'merchant_id' => 'required|exists:merchants,id',
                'shipment_type_id' => 'required|exists:shipment_types,id',
                'payment_type_id' => 'required|exists:payment_types,id'
            ]);
            $transaction->update([
                'date' => $request->date,
                'status' => $request->status,
                'total_amount' => $request->total_amount,
                'merchant_id' => $request->merchant_id,
                'shipment_type_id' => $request->shipment_type_id,
                'payment_type_id' => $request->payment_type_id
            ]);
            DB::commit();
            return APIFormatter::createAPI(200, 'success', 'Transaction updated', $transaction);
        } catch (\Throwable $th) {
            DB::rollBack();
            return APIFormatter::createAPI(400, 'fail', 'Failed to update transaction', $th->getMessage());
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $transaction = Transactions::findOrFail($id);
            if (!$transaction) {
                return APIFormatter::createAPI(200, 'success', 'Transaction not found', null);
            }
            $transaction->delete();
            DB::commit();
            return APIFormatter::createAPI(200, 'success', 'Transaction deleted', null);
        } catch (\Throwable $th) {
            DB::rollBack();
            return APIFormatter::createAPI(400, 'fail', 'Failed to delete transaction', $th->getMessage());
        }
    }
}
