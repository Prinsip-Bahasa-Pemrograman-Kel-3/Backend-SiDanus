<?php

namespace App\Http\Controllers\api\Transactions;

use Illuminate\Http\Request;
use App\Helpers\APIFormatter;
use App\Models\ReasonTransactionsCancellations;
use Illuminate\Support\Facades\DB;

class ReasonTransactionsCancellationsController
{
    public function index()
    {
        try {
            $reasonTransactionsCancellations = ReasonTransactionsCancellations::all();
            if ($reasonTransactionsCancellations->isEmpty()) {
                return APIFormatter::createAPI(200, 'success', 'Reason Transactions Cancellations not found', null);
            }
            return APIFormatter::createAPI(200, 'success', 'Reason Transactions Cancellations found', $reasonTransactionsCancellations);
        } catch (\Throwable $th) {
            return APIFormatter::createAPI(400, 'fail', 'Failed to get reason transactions cancellations', $th->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $reasonTransactionCancellation = ReasonTransactionsCancellations::findOrFail($id);
            if (!$reasonTransactionCancellation) {
                return APIFormatter::createAPI(200, 'success', 'Reason Transaction Cancellation not found', null);
            }
            return APIFormatter::createAPI(200, 'success', 'Reason Transaction Cancellation found', $reasonTransactionCancellation);
        } catch (\Throwable $th) {
            return APIFormatter::createAPI(400, 'fail', 'Failed to get reason transaction cancellation', $th->getMessage());
        }
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'reason' => 'required|string'
            ]);
            $reasonTransactionCancellation = ReasonTransactionsCancellations::create([
                'reason' => $request->reason
            ]);
            DB::commit();
            return APIFormatter::createAPI(200, 'success', 'Reason Transaction Cancellation created', $reasonTransactionCancellation);
        } catch (\Throwable $th) {
            DB::rollBack();
            return APIFormatter::createAPI(400, 'fail', 'Failed to create reason transaction cancellation', $th->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $reasonTransactionCancellation = ReasonTransactionsCancellations::findOrFail($id);
            if (!$reasonTransactionCancellation) {
                return APIFormatter::createAPI(200, 'success', 'Reason Transaction Cancellation not found', null);
            }
            $request->validate([
                'reason' => 'required|string'
            ]);
            $reasonTransactionCancellation->update([
                'reason' => $request->reason
            ]);
            DB::commit();
            return APIFormatter::createAPI(200, 'success', 'Reason Transaction Cancellation updated', $reasonTransactionCancellation);
        } catch (\Throwable $th) {
            DB::rollBack();
            return APIFormatter::createAPI(400, 'fail', 'Failed to update reason transaction cancellation', $th->getMessage());
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $reasonTransactionCancellation = ReasonTransactionsCancellations::findOrFail($id);
            if (!$reasonTransactionCancellation) {
                return APIFormatter::createAPI(200, 'success', 'Reason Transaction Cancellation not found', null);
            }
            $reasonTransactionCancellation->delete();
            DB::commit();
            return APIFormatter::createAPI(200, 'success', 'Reason Transaction Cancellation deleted', null);
        } catch (\Throwable $th) {
            DB::rollBack();
            return APIFormatter::createAPI(400, 'fail', 'Failed to delete reason transaction cancellation', $th->getMessage());
        }
    }
}
