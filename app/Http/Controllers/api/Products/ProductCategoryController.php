<?php

namespace App\Http\Controllers\api\Products;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product_Category;
use App\Helpers\APIFormatter;
use Illuminate\Routing\Controller;

class ProductCategoryController extends Controller
{
    public function index()
    {
        try {
            $product_categories = Product_Category::all();
            if ($product_categories->isEmpty()) {
                return APIFormatter::createAPI(200, 'success', 'Product Categories not found', null);
            }
            return APIFormatter::createAPI(200, 'success', 'Product Categories found', $product_categories);
        } catch (\Throwable $th) {
            return APIFormatter::createAPI(400, 'fail', 'Failed to get product categories', $th->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $product_category = Product_Category::find($id);
            if (!$product_category) {
                return APIFormatter::createAPI(200, 'success', 'Product Category not found', null);
            }
            return APIFormatter::createAPI(200, 'success', 'Product Category found', $product_category);
        } catch (\Throwable $th) {
            return APIFormatter::createAPI(400, 'fail', 'Failed to get product category', $th->getMessage());
        }

        
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);
        DB::beginTransaction();
        try {
            $product_category = Product_Category::create([
                'name' => $request->name
            ]);
            DB::commit();
            return APIFormatter::createAPI(201, 'success', 'Product Category created', $product_category);
        } catch (\Throwable $e) {
            DB::rollBack();
            return APIFormatter::createAPI(400, 'fail', 'Failed to create product category', null);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);
        DB::beginTransaction();
        try {
            $product_category = Product_Category::findOrFail($id);
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
            return APIFormatter::createAPI(400, 'fail', 'Failed to update product category', null);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $product_category = Product_Category::findOrFail($id);
            if (!$product_category) {
                return APIFormatter::createAPI(200, 'success', 'Product Category not found', null);
            }
            $product_category->delete();
            DB::commit();
            return APIFormatter::createAPI(200, 'success', 'Product Category deleted', null);
        } catch (\Throwable $e) {
            DB::rollBack();
            return APIFormatter::createAPI(400, 'fail', 'Failed to delete product category', null);
        }
    }
}
