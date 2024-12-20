<?php

namespace App\Http\Controllers\api\Products;

use App\Helpers\APIFormatter;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Log;
use Illuminate\Routing\Controller;


class ProductController extends Controller
{
    public function index(Request $request)
    {
        try {
            $request->validate([
                'category_id' => 'nullable|integer|exists:product_categories,id',
                'min_price' => 'nullable|numeric|min:0',
                'max_price' => 'nullable|numeric|min:0',
            ]);

            $query = Product::when($request->category_id, function ($q) use ($request) {
                return $q->where('product_category_id', $request->category_id);
            })->when($request->min_price, function ($q) use ($request) {
                return $q->where('price', '>=', $request->min_price);
            })->when($request->max_price, function ($q) use ($request) {
                return $q->where('price', '<=', $request->max_price);
            });

            // Eksekusi query untuk mendapatkan produk
            $products = $query->Paginate(10);

            // Cek apakah produk ditemukan
            if ($products->isEmpty()) {
                return APIFormatter::createAPI(200, 'success', 'Products not found', null);
            }

            // Return response dengan data produk yang ditemukan
            return APIFormatter::createAPI(200, 'success', 'Products found', $products);
        } catch (\Throwable $e) {
            return APIFormatter::createAPI(500, 'error', 'Failed to get products', Log::error($e->getMessage()));
        }
    }


    public function show($id)
    {
        try {
            $product = Product::findOrFail($id);
            if (!$product) {
                return APIFormatter::createAPI(200, 'success', 'Product not found', null);
            }
            return APIFormatter::createAPI(200, 'success', 'Product found', $product);
        } catch (\Throwable $th) {
            return APIFormatter::createAPI(400, 'error', 'Failed to get product', Log::error($th->getMessage()));
        }
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'price' => 'required|numeric',
                'stock' => 'required|integer',
                'minimum_order' => 'required|integer',
                'description' => 'nullable|string',
                'product_category_id' => 'required|exists:product_categories,id',
                // 'merchant_id' => 'required|exists:merchants,id'
            ]);
            $product = Product::create([
                'name' => $request->name,
                'price' => $request->price,
                'stock' => $request->stock,
                'minimum_order' => $request->minimum_order,
                'description' => $request->description,
                'product_category_id' => $request->product_category_id,
                // 'merchant_id' => $request->merchant_id
            ]);
            DB::commit();
            return APIFormatter::createAPI(201, 'success', 'Product created', $product);
        } catch (\Throwable $e) {
            DB::rollBack();
            return APIFormatter::createAPI(500, 'fail', 'Failed to create product', Log::error($e->getMessage()));
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'minimum_order' => 'required|integer',
            'description' => 'nullable|string',
            'product_category_id' => 'required|exists:product_categories,id',
            'merchant_id' => 'required|exists:merchants,id'
        ]);
        DB::beginTransaction();
        try {
            $product =  product::findOrFail($id);
            if (!$product) {
                return APIFormatter::createAPI(200, 'success', 'Product not found', null);
            }
            $product->update([
                'name' => $request->name,
                'price' => $request->price,
                'stock' => $request->stock,
                'minimum_order' => $request->minimum_order,
                'description' => $request->description,
                'product_category_id' => $request->product_category_id,
                'merchant_id' => $request->merchant_id
            ]);
            DB::commit();
            return APIFormatter::createAPI(200, 'success', 'Product updated', $product);
        } catch (\Throwable $e) {
            DB::rollBack();
            return APIFormatter::createAPI(400, 'fail', 'Failed to update product', Log::error($e->getMessage()));
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $product = Product::findOrFail($id);
            if (!$product) {
                return APIFormatter::createAPI(200, 'success', 'Product not found', null);
            }
            ProductImage::where('product_id', $id)->delete();
            $product->delete();
            DB::commit();
            return APIFormatter::createAPI(200, 'success', 'Product deleted', null);
        } catch (\Throwable $e) {
            DB::rollBack();
            return APIFormatter::createAPI(400, 'fail', 'Failed to delete product', Log::error($e->getMessage()));
        }
    }
}
