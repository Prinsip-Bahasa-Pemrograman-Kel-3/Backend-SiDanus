<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\AuthOrganization\AuthOrganizationController;
use App\Http\Controllers\api\Products\ProductController;
use App\Http\Controllers\api\Products\ProductCategoryController;
use App\Http\Controllers\api\Products\ProductImageController;
use App\Http\Controllers\api\Products\ProductReviewController;
use App\Http\Controllers\api\Transactions\TransactionsController;
use App\Http\Controllers\api\Transactions\ShipmentTypesController;
use App\Http\Controllers\api\Transactions\PaymentTypesController;
use App\Http\Controllers\api\Transactions\ReasonTransactionsCancellationsController;
use App\Http\Controllers\api\Transactions\TransactionsCancellationsController;
use App\Http\Controllers\api\AuthOrganization\RegisterController;
use App\Http\Controllers\api\AuthOrganization\OrganizationController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login', [AuthOrganizationController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthOrganizationController::class, 'logout']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});
Route::apiResource('organizations', OrganizationController::class);

Route::apiResource ('product', ProductController::class);
Route::apiResource ('product_category', ProductCategoryController::class);
Route::apiResource ('product_review', ProductReviewController::class);
Route::apiResource ('product_images', ProductImageController::class);
Route::apiResource('transactions', TransactionsController::class);
Route::apiResource('shipment_types', ShipmentTypesController::class);
Route::apiResource('payment_types', PaymentTypesController::class);
Route::apiResource('reason_transactions_cancellations', ReasonTransactionsCancellationsController::class);
Route::apiResource('transactions_cancellations', TransactionsCancellationsController::class);