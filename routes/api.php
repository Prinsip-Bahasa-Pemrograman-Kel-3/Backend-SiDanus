<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\Products\ProductController;
use App\Http\Controllers\api\Products\ProductCategoryController;
use App\Http\Controllers\api\Products\ProductImageController;
use App\Http\Controllers\api\Products\ProductReviewController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource ('product', ProductController::class);
Route::apiResource ('product_category', ProductCategoryController::class);
Route::apiResource ('product_review', ProductReviewController::class);
Route::apiResource ('product_images', ProductImageController::class);