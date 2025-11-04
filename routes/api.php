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
use App\Http\Controllers\FeaturesTopNavbarController;
use App\Http\Controllers\FeaturesSidebarController;
use App\Http\Controllers\FeaturesLogoController;
use App\Http\Controllers\WebHomeController;
use App\Http\Controllers\WebHeaderLogoController;
use App\Http\Controllers\WebFooterLogoController;
use App\Http\Controllers\HomeSliderController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\OrderController;

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
    Route::post('/apply', [CouponCategory::class, 'apply']);
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
Route::prefix('featurestopnavbar')->group(function() {
    Route::get('/', [FeaturesTopNavbarController::class, 'index']);
    Route::post('/', [FeaturesTopNavbarController::class, 'store']);
    Route::put('/{id}', [FeaturesTopNavbarController::class, 'update']);
    Route::delete('/{id}', [FeaturesTopNavbarController::class, 'destroy']);

});
Route::prefix('featuresidebar')->group(function() {
    Route::get('/', [FeaturesSidebarController::class, 'index']);
    Route::post('/', [FeaturesSidebarController::class, 'store']);
    Route::put('/{id}', [FeaturesSidebarController::class, 'update']);
    Route::delete('/{id}', [FeaturesSidebarController::class, 'destroy']);

});
Route::prefix('featurelogo')->group(function() {
    Route::get('/', [FeaturesLogoController::class, 'index']);
    Route::post('/', [FeaturesLogoController::class, 'store']);
    Route::put('/{id}', [FeaturesLogoController::class, 'update']);
    Route::delete('/{id}', [FeaturesLogoController::class, 'destroy']);

});
Route::prefix('webhome')->group(function() {
    Route::get('/', [WebHomeController::class, 'index']);
    Route::post('/', [WebHomeController::class, 'store']);
    Route::put('/{id}', [WebHomeController::class, 'update']);
    Route::delete('/{id}', [WebHomeController::class, 'destroy']);

});
Route::prefix('webheaderlogos')->group(function() {
    Route::get('/', [WebHeaderLogoController::class, 'index']);
    Route::post('/', [WebHeaderLogoController::class, 'store']);
    Route::put('/{id}', [WebHeaderLogoController::class, 'update']);
    Route::delete('/{id}', [WebHeaderLogoController::class, 'destroy']);

});
Route::prefix('webfooterlogo')->group(function() {
    Route::get('/', [WebFooterLogoController::class, 'index']);
    Route::post('/', [WebFooterLogoController::class, 'store']);
    Route::put('/{id}', [WebFooterLogoController::class, 'update']);
    Route::delete('/{id}', [WebFooterLogoController::class, 'destroy']);

});
Route::prefix('homesliders')->group(function() {
    Route::get('/', [HomeSliderController::class, 'index']);
    Route::post('/', [HomeSliderController::class, 'store']);
    Route::put('/{id}', [HomeSliderController::class, 'update']);
    Route::delete('/{id}', [HomeSliderController::class, 'destroy']);

});
Route::prefix('videos')->group(function() {
    Route::get('/', [VideoController::class, 'index']);
    Route::post('/', [VideoController::class, 'store']);
    Route::put('/{id}', [VideoController::class, 'update']);
    Route::delete('/{id}', [VideoController::class, 'destroy']);

});




Route::post('/orders', [OrderController::class, 'store']);
Route::get('/orders', [OrderController::class, 'index']);
Route::get('/orders/{id}', [OrderController::class, 'show']);
Route::put('/orders/{id}', [OrderController::class, 'update']);
Route::delete('/orders/{id}', [OrderController::class, 'destroy']); 

// Optional: Get orders by user ID
Route::get('/user/{userId}/orders', [OrderController::class, 'userOrders']);
Route::get('/orders/latest', [OrderController::class, 'latestOrder']);
