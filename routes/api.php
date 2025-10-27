<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\SizeController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\CouponCategory;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\ShippingController;
use App\Http\Controllers\ProductController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix('category')->group(function () {
    Route::get('/', [CategoryController::class, 'index']);       
    Route::post('/', [CategoryController::class, 'store']);    
    Route::get('/{id}', [CategoryController::class, 'show']);   
    Route::put('/{id}', [CategoryController::class, 'update']);  
    Route::delete('/{id}', [CategoryController::class, 'destroy']); 
});
Route::prefix('brand')->group(function () {
    Route::get('/', [BrandController::class, 'index']);       
    Route::post('/', [BrandController::class, 'store']);    
    Route::get('/{id}', [BrandController::class, 'show']);   
    Route::put('/{id}', [BrandController::class, 'update']);  
    Route::delete('/{id}', [BrandController::class, 'destroy']); 
});
Route::prefix('color')->group(function () {
    Route::get('/', [ColorController::class, 'index']);       
    Route::post('/', [ColorController::class, 'store']);    
    Route::get('/{id}', [ColorController::class, 'show']);   
    Route::put('/{id}', [ColorController::class, 'update']);  
    Route::delete('/{id}', [ColorController::class, 'destroy']); 
});




Route::prefix('size')->group(function() {
    Route::get('/', [SizeController::class, 'index']);
    Route::post('/', [SizeController::class, 'store']);
    Route::put('/{id}', [SizeController::class, 'update']);
    Route::delete('/{id}', [SizeController::class, 'destroy']);
});
Route::prefix('discounts')->group(function() {
    Route::get('/', [DiscountController::class, 'index']);
    Route::post('/', [DiscountController::class, 'store']);
    Route::put('/{id}', [DiscountController::class, 'update']);
    Route::delete('/{id}', [DiscountController::class, 'destroy']);
});

Route::prefix('coupons')->group(function() {
    Route::get('/', [CouponCategory::class, 'index']);
    Route::post('/', [CouponCategory::class, 'store']);
    Route::put('/{id}', [CouponCategory::class, 'update']);
    Route::delete('/{id}', [CouponCategory::class, 'destroy']);
    Route::post('/apply', [CouponController::class, 'apply']);
});

Route::prefix('sections')->group(function() {
    Route::get('/', [SectionController::class, 'index']);
    Route::post('/', [SectionController::class, 'store']);
    Route::put('/{id}', [SectionController::class, 'update']);
    Route::delete('/{id}', [SectionController::class, 'destroy']);
    
});

Route::prefix('shipping')->group(function() {
    Route::get('/', [ShippingController::class, 'index']);
    Route::post('/', [ShippingController::class, 'store']);
    Route::put('/{id}', [ShippingController::class, 'update']);
    Route::delete('/{id}', [ShippingController::class, 'destroy']);
    
});
Route::prefix('products')->group(function() {
    Route::get('/', [ProductController::class, 'index']);
    Route::post('/', [ProductController::class, 'store']);
    Route::put('/{id}', [ProductController::class, 'update']);
    Route::delete('/{id}', [ProductController::class, 'destroy']);
    
});
