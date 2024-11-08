<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\ProductController;
use App\Http\Controllers\api\ProductCategoryController;
use App\Http\Controllers\api\ProductImageController;
use App\Http\Controllers\api\ProductReviewController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource ('product', ProductController::class);
Route::apiResource ('product_category', ProductCategoryController::class);
Route::apiResource ('product_review', ProductReviewController::class);
Route::apiResource ('product_images', ProductImageController::class);