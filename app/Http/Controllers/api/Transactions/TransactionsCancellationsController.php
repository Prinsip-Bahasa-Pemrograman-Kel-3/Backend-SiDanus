<?php

namespace App\Http\Controllers\api\Transactions;

use Illuminate\Http\Request;
use App\Helpers\APIFormatter;
use App\Models\TransactionsCancellations;
use Illuminate\Support\Facades\DB;

class TransactionsCancellationsController
{
    public function index()
    {
        try {
            $transactionsCancellations = TransactionsCancellations::all();
            if ($transactionsCancellations->isEmpty()) {
                return APIFormatter::createAPI(200, 'success', 'Transactions Cancellations not found', null);
            }
            return APIFormatter::createAPI(200, 'success', 'Transactions Cancellations found', $transactionsCancellations);
        } catch (\Throwable $th) {
            return APIFormatter::createAPI(400, 'fail', 'Failed to get transactions cancellations', $th->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $transactionCancellation = TransactionsCancellations::findOrFail($id);
            if (!$transactionCancellation) {
                return APIFormatter::createAPI(200, 'success', 'Transaction Cancellation not found', null);
            }
            return APIFormatter::createAPI(200, 'success', 'Transaction Cancellation found', $transactionCancellation);
        } catch (\Throwable $th) {
            return APIFormatter::createAPI(400, 'fail', 'Failed to get transaction cancellation', $th->getMessage());
        }
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'transaction_id' => 'required|exists:transactions,id',
                'reason_id' => 'required|exists:reason_transactions_cancellations,id',
                'description' => 'nullable|string',
                'reason_cancellation_id' => 'required|exists:reason_cancellations,id'
            ]);
            $transactionCancellation = TransactionsCancellations::create([
                'transaction_id' => $request->transaction_id,
                'reason_id' => $request->reason_id,
                'description' => $request->description,
                'reason_cancellation_id' => $request->reason_cancellation_id
            ]);
            DB::commit();
            return APIFormatter::createAPI(200, 'success', 'Transaction Cancellation created', $transactionCancellation);
        } catch (\Throwable $th) {
            DB::rollBack();
            return APIFormatter::createAPI(400, 'fail', 'Failed to create transaction cancellation', $th->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $transactionCancellation = TransactionsCancellations::findOrFail($id);
            if (!$transactionCancellation) {
                return APIFormatter::createAPI(200, 'success', 'Transaction Cancellation not found', null);
            }
            $request->validate([
                'transaction_id' => 'required|exists:transactions,id',
                'reason_id' => 'required|exists:reason_transactions_cancellations,id',
                'description' => 'nullable|string',
                'reason_cancellation_id' => 'required|exists:reason_cancellations,id'
            ]);
            $transactionCancellation->update([
                'transaction_id' => $request->transaction_id,
                'reason_id' => $request->reason_id,
                'description' => $request->description,
                'reason_cancellation_id' => $request->reason_cancellation_id
            ]);
            DB::commit();
            return APIFormatter::createAPI(200, 'success', 'Transaction Cancellation updated', $transactionCancellation);
        } catch (\Throwable $th) {
            DB::rollBack();
            return APIFormatter::createAPI(400, 'fail', 'Failed to update transaction cancellation', $th->getMessage());
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $transactionCancellation = TransactionsCancellations::findOrFail($id);
            if (!$transactionCancellation) {
                return APIFormatter::createAPI(200, 'success', 'Transaction Cancellation not found', null);
            }
            $transactionCancellation->delete();
            DB::commit();
            return APIFormatter::createAPI(200, 'success', 'Transaction Cancellation deleted', null);
        } catch (\Throwable $th) {
            DB::rollBack();
            return APIFormatter::createAPI(400, 'fail', 'Failed to delete transaction cancellation', $th->getMessage());
        }
    }
}
