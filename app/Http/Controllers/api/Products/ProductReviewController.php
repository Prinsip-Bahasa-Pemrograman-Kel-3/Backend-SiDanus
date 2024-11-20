<?php

namespace App\Http\Controllers\api\Products;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\ProductReview;
use App\Helpers\APIFormatter;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;

class ProductReviewController extends Controller
{
    public function index(Request $request)
    {
        try {
            $request->validate([
                'product_id' => 'nullable|integer|exists:products,id',
                'rate' => 'nullable|numeric|min:0|max:5'
            ]);
            $query = ProductReview::when($request->product_id, function ($q) use ($request) {
                return $q->where('product_id', $request->product_id);
            })->when($request->rate, function ($q) use ($request) {
                return $q->where('rate', $request->rate);
            });

            $product_reviews = $query->paginate(5);

            if ($product_reviews->isEmpty()) {
                return APIFormatter::createAPI(200, 'success', 'Product Reviews not found', null);
            }

            return APIFormatter::createAPI(200, 'success', 'Product Reviews found', $product_reviews);
        } catch (\Throwable $th) {
            return APIFormatter::createAPI(400, 'error', 'Failed to get product reviews', Log::error($th->getMessage()));
        }
    }

    public function show($id)
    {
        try {
            $product_review = ProductReview::find($id);
            if (!$product_review) {
                return APIFormatter::createAPI(200, 'success', 'Product Review not found', null);
            }
            return APIFormatter::createAPI(200, 'success', 'Product Review found', $product_review);
        } catch (\Throwable $th) {
            return APIFormatter::createAPI(400, 'error', 'Failed to get product review', Log::error($th->getMessage()));
        }
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'product_id' => 'required|exists:products,id',
                'user_id' => 'required|exists:users,id',
                'rating' => 'required|numeric',
                'review' => 'nullable|string'
            ]);
            $product_review = ProductReview::create([
                'product_id' => $request->product_id,
                'user_id' => $request->user_id,
                'rating' => $request->rating,
                'review' => $request->review
            ]);
            DB::commit();
            return APIFormatter::createAPI(201, 'success', 'Product Review created', $product_review);
        } catch (\Exception $e) {
            DB::rollBack();
            return APIFormatter::createAPI(400, 'fail', 'Failed to create product review', Log::error($e->getMessage()));
        }
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'product_id' => 'required|exists:products,id',
                'user_id' => 'required|exists:users,id',
                'rating' => 'required|numeric',
                'review' => 'nullable|string'
            ]);
            $product_review = ProductReview::findOrFail($id);
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
            return APIFormatter::createAPI(400, 'fail', 'Failed to update product review', Log::error($e->getMessage()));
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $product_review = ProductReview::findOrFail($id);
            if (!$product_review) {
                return APIFormatter::createAPI(200, 'success', 'Product Review not found', null);
            }
            $product_review->delete();
            DB::commit();
            return APIFormatter::createAPI(200, 'success', 'Product Review deleted', null);
        } catch (\Throwable $e) {
            DB::rollBack();
            return APIFormatter::createAPI(400, 'fail', 'Failed to delete product review', Log::error($e->getMessage()));
        }
    }
}
