<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Product_Image;
use App\Helpers\APIFormatter;

class ProductImageController extends Controller
{
    public function index()
    {
        $product_images = Product_Image::all();
        if ($product_images->isEmpty()) {
            return APIFormatter::createAPI(404, 'error', 'Product Images not found', null);
        }
        return APIFormatter::createAPI(200, 'success', 'Product Images found', $product_images);
    }

    public function show($id)
    {
        $product_image = Product_Image::find($id);
        if (!$product_image) {
            return APIFormatter::createAPI(404, 'error', 'Product Image not found', null);
        }
        return APIFormatter::createAPI(200, 'success', 'Product Image found', $product_image);
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $product_image = Product_Image::create([
                'product_id' => $request->product_id,
                'path' => $request->path
            ]);
            DB::commit();
            return APIFormatter::createAPI(201, 'success', 'Product Image created', $product_image);
        } catch (\Exception $e) {
            DB::rollBack();
            return APIFormatter::createAPI(400, 'fail', 'Failed to create product image', null);
        }
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $product_image = Product_Image::findOrFail($id);
            $product_image->update([
                'product_id' => $request->product_id,
                'path' => $request->path
            ]);
            DB::commit();
            return APIFormatter::createAPI(200, 'success', 'Product Image updated', $product_image);
        } catch (\Exception $e) {
            DB::rollBack();
            return APIFormatter::createAPI(400, 'fail', 'Failed to update product image', null);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $product_image = Product_Image::findOrFail($id);
            $product_image->delete();
            DB::commit();
            return APIFormatter::createAPI(200, 'success', 'Product Image deleted', null);
        } catch (\Exception $e) {
            DB::rollBack();
            return APIFormatter::createAPI(400, 'fail', 'Failed to delete product image', null);
        }
    }
}
