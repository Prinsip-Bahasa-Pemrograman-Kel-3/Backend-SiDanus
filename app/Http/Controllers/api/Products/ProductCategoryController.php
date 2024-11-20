<?php

namespace App\Http\Controllers\api\Products;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\ProductCategory;
use App\Helpers\APIFormatter;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;

class ProductCategoryController extends Controller
{
    public function index()
    {
        try {
            $product_categories = ProductCategory::all();
            if ($product_categories->isEmpty()) {
                return APIFormatter::createAPI(200, 'success', 'Product Categories not found', null);
            }
            return APIFormatter::createAPI(200, 'success', 'Product Categories found', $product_categories);
        } catch (\Throwable $th) {
            return APIFormatter::createAPI(400, 'fail', 'Failed to get product categories', Log::error($th->getMessage()));
        }
    }

    public function show($id)
    {
        try {
            $product_category = ProductCategory::find($id);
            if (!$product_category) {
                return APIFormatter::createAPI(200, 'success', 'Product Category not found', null);
            }
            return APIFormatter::createAPI(200, 'success', 'Product Category found', $product_category);
        } catch (\Throwable $th) {
            return APIFormatter::createAPI(400, 'fail', 'Failed to get product category', Log::error($th->getMessage()));
        }

        
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'name' => 'required|string|max:255'
            ]);
            $product_category = ProductCategory::create([
                'name' => $request->name
            ]);
            DB::commit();
            return APIFormatter::createAPI(201, 'success', 'Product Category created', $product_category);
        } catch (\Throwable $e) {
            DB::rollBack();
            return APIFormatter::createAPI(400, 'fail', 'Failed to create product category', Log::error($e->getMessage()));
        }
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'name' => 'required|string|max:255'
            ]);
            $product_category = ProductCategory::findOrFail($id);
            if (!$product_category) {
                return APIFormatter::createAPI(200, 'success', 'Product Category not found', null);
            }
            $product_category->update([
                'name' => $request->name
            ]);
            DB::commit();
            return APIFormatter::createAPI(200, 'success', 'Product Category updated', $product_category);
        } catch (\Throwable $e) {
            DB::rollBack();
            return APIFormatter::createAPI(400, 'fail', 'Failed to update product category', Log::error($e->getMessage()));
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $product_category = ProductCategory::findOrFail($id);
            if (!$product_category) {
                return APIFormatter::createAPI(200, 'success', 'Product Category not found', null);
            }   
            $product_category->delete();
            DB::commit();
            return APIFormatter::createAPI(200, 'success', 'Product Category deleted', null);
        } catch (\Throwable $e) {
            DB::rollBack();
            return APIFormatter::createAPI(400, 'fail', 'Failed to delete product category', Log::error($e->getMessage()));
        }
    }
}
