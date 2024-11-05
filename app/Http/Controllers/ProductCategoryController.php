<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product_Category;
use App\Helpers\APIFormatter;

class ProductCategoryController extends Controller
{
    public function index()
    {
        $product_categories = Product_Category::all();
        if ($product_categories->isEmpty()) {
            return APIFormatter::createAPI(404, 'error', 'Product Categories not found', null);
        }
        return APIFormatter::createAPI(200, 'success', 'Product Categories found', $product_categories);
    }

    public function show($id)
    {
        $product_category = Product_Category::find($id);
        if (!$product_category) {
            return APIFormatter::createAPI(404, 'error', 'Product Category not found', null);
        }
        return APIFormatter::createAPI(200, 'success', 'Product Category found', $product_category);
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
            $product_category->delete();
            DB::commit();
            return APIFormatter::createAPI(200, 'success', 'Product Category deleted', null);
        } catch (\Throwable $e) {
            DB::rollBack();
            return APIFormatter::createAPI(400, 'fail', 'Failed to delete product category', null);
        }
    }
}
