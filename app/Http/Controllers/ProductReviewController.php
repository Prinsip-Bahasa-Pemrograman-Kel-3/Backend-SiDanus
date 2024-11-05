<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product_Review;
use App\Helpers\APIFormatter;

class ProductReviewController extends Controller
{
    public function index()
    {
        $product_reviews = Product_Review::all();
        if ($product_reviews->isEmpty()) {
            return APIFormatter::createAPI(404, 'error', 'Product Reviews not found', null);
        }
        return APIFormatter::createAPI(200, 'success', 'Product Reviews found', $product_reviews);
    }

    public function show($id)
    {
        $product_review = Product_Review::find($id);
        if (!$product_review) {
            return APIFormatter::createAPI(404, 'error', 'Product Review not found', null);
        }
        return APIFormatter::createAPI(200, 'success', 'Product Review found', $product_review);
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'user_id' => 'required|exists:users,id',
            'rating' => 'required|numeric',
            'review' => 'nullable|string'
        ]);
        DB::beginTransaction();
        try {
            $product_review = Product_Review::create([
                'product_id' => $request->product_id,
                'user_id' => $request->user_id,
                'rating' => $request->rating,
                'review' => $request->review
            ]);
            DB::commit();
            return APIFormatter::createAPI(201, 'success', 'Product Review created', $product_review);
        } catch (\Exception $e) {
            DB::rollBack();
            return APIFormatter::createAPI(400, 'fail', 'Failed to create product review', null);
        }
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $product_review = Product_Review::findOrFail($id);
            $product_review->update([
                'product_id' => $request->product_id,
                'user_id' => $request->user_id,
                'rating' => $request->rating,
                'review' => $request->review
            ]);
            DB::commit();
            return APIFormatter::createAPI(200, 'success', 'Product Review updated', $product_review);
        } catch (\Throwable $e) {
            DB::rollBack();
            return APIFormatter::createAPI(400, 'fail', 'Failed to update product review', null);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $product_review = Product_Review::findOrFail($id);
            $product_review->delete();
            DB::commit();
            return APIFormatter::createAPI(200, 'success', 'Product Review deleted', null);
        } catch (\Throwable $e) {
            DB::rollBack();
            return APIFormatter::createAPI(400, 'fail', 'Failed to delete product review', null);
        }
    }
}
