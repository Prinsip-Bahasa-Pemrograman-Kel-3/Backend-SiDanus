<?php

namespace App\Http\Controllers\api\Products;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product_Review;
use App\Helpers\APIFormatter;
use Illuminate\Routing\Controller;

class ProductReviewController extends Controller
{
    public function index()
    {
        try {
            $product_reviews = Product_Review::all();
            if ($product_reviews->isEmpty()) {
                return APIFormatter::createAPI(200, 'success', 'Product Reviews not found', null);
            }
            return APIFormatter::createAPI(200, 'success', 'Product Reviews found', $product_reviews);
        } catch (\Throwable $th) {
            return APIFormatter::createAPI(400, 'error', 'Failed to get product reviews', $th->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $product_review = Product_Review::find($id);
            if (!$product_review) {
                return APIFormatter::createAPI(200, 'success', 'Product Review not found', null);
            }
            return APIFormatter::createAPI(200, 'success', 'Product Review found', $product_review);
        } catch (\Throwable $th) {
            return APIFormatter::createAPI(400, 'error', 'Failed to get product review', $th->getMessage());
        }
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
            return APIFormatter::createAPI(400, 'fail', 'Failed to create product review', $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'user_id' => 'required|exists:users,id',
            'rating' => 'required|numeric',
            'review' => 'nullable|string'
        ]);
        DB::beginTransaction();
        try {
            $product_review = Product_Review::findOrFail($id);
            if (!$product_review) {
                return APIFormatter::createAPI(200, 'success', 'Product Review not found', null);
            }
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
            return APIFormatter::createAPI(400, 'fail', 'Failed to update product review', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $product_review = Product_Review::findOrFail($id);
            if (!$product_review) {
                return APIFormatter::createAPI(200, 'success', 'Product Review not found', null);
            }
            $product_review->delete();
            DB::commit();
            return APIFormatter::createAPI(200, 'success', 'Product Review deleted', null);
        } catch (\Throwable $e) {
            DB::rollBack();
            return APIFormatter::createAPI(400, 'fail', 'Failed to delete product review', $e->getMessage());
        }
    }
}
