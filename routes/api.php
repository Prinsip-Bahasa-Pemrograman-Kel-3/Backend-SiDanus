<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\api\AuthOrganization\AuthOrganizationController;

use App\Http\Controllers\api\AuthStudentController;

use App\Http\Controllers\api\Products\ProductController;
use App\Http\Controllers\api\Merchants\MerchantController;
use App\Http\Controllers\api\Products\ProductImageController;
use App\Http\Controllers\api\Products\ProductReviewController;
use App\Http\Controllers\api\Products\ProductCategoryController;
use App\Http\Controllers\api\Merchants\MerchantSubmissionController;
use App\Http\Controllers\api\Merchants\MerchantOperationalTimesController;
use App\Http\Controllers\api\StudentController;
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

// Route::post('student', StudentController::class);
Route::post('/auth/student/register', [AuthStudentController::class, 'register']);
Route::post('/auth/student/login', [AuthStudentController::class, 'login']);
Route::post('/auth/student/logout', [AuthStudentController::class, 'logout'])->middleware('auth:sanctum');
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/auth/student/logout', [AuthStudentController::class, 'logout']);
    Route::get('/student/profile', [AuthStudentController::class, 'profile']);
});

Route::apiResource ('merchant', MerchantController::class);
Route::apiResource ('merchant_submission', MerchantSubmissionController::class);
Route::apiResource('merchant_operational_times', MerchantOperationalTimesController::class);

Route::apiResource('transactions', TransactionsController::class);
Route::apiResource('shipment_types', ShipmentTypesController::class);
Route::apiResource('payment_types', PaymentTypesController::class);
Route::apiResource('reason_transactions_cancellations', ReasonTransactionsCancellationsController::class);
Route::apiResource('transactions_cancellations', TransactionsCancellationsController::class);

