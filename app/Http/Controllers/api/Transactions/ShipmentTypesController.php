<?php

namespace App\Http\Controllers\api\Transactions;

use Illuminate\Http\Request;
use App\Helpers\APIFormatter;
use App\Models\ShipmentTypes;
use Illuminate\Support\Facades\DB;

class ShipmentTypesController
{
    public function index()
    {
        try {
            $shipmentTypes = ShipmentTypes::all();
            if ($shipmentTypes->isEmpty()) {
                return APIFormatter::createAPI(200, 'success', 'Shipment Types not found', null);
            }
            return APIFormatter::createAPI(200, 'success', 'Shipment Types found', $shipmentTypes);
        } catch (\Throwable $th) {
            return APIFormatter::createAPI(400, 'fail', 'Failed to get shipment types', $th->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $shipmentType = ShipmentTypes::findOrFail($id);
            if (!$shipmentType) {
                return APIFormatter::createAPI(200, 'success', 'Shipment Type not found', null);
            }
            return APIFormatter::createAPI(200, 'success', 'Shipment Type found', $shipmentType);
        } catch (\Throwable $th) {
            return APIFormatter::createAPI(400, 'fail', 'Failed to get shipment type', $th->getMessage());
        }
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'name' => 'required|string'
            ]);
            $shipmentType = ShipmentTypes::create([
                'name' => $request->name
            ]);
            DB::commit();
            return APIFormatter::createAPI(200, 'success', 'Shipment Type created', $shipmentType);
        } catch (\Throwable $th) {
            DB::rollBack();
            return APIFormatter::createAPI(400, 'fail', 'Failed to create shipment type', $th->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $shipmentType = ShipmentTypes::findOrFail($id);
            if (!$shipmentType) {
                return APIFormatter::createAPI(200, 'success', 'Shipment Type not found', null);
            }
            $request->validate([
                'name' => 'required|string'
            ]);
            $shipmentType->update([
                'name' => $request->name
            ]);
            DB::commit();
            return APIFormatter::createAPI(200, 'success', 'Shipment Type updated', $shipmentType);
        } catch (\Throwable $th) {
            DB::rollBack();
            return APIFormatter::createAPI(400, 'fail', 'Failed to update shipment type', $th->getMessage());
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $shipmentType = ShipmentTypes::findOrFail($id);
            if (!$shipmentType) {
                return APIFormatter::createAPI(200, 'success', 'Shipment Type not found', null);
            }
            $shipmentType->delete();
            DB::commit();
            return APIFormatter::createAPI(200, 'success', 'Shipment Type deleted', null);
        } catch (\Throwable $th) {
            DB::rollBack();
            return APIFormatter::createAPI(400, 'fail', 'Failed to delete shipment type', $th->getMessage());
        }
    }
}
