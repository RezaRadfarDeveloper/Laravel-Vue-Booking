<?php

use App\Models\Bookable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Route::get('bookables','App\Http\Controllers\Api\BookableController@index');
//Route::get('bookables/{id}','App\Http\Controllers\Api\BookableController@show');

Route::apiResource('bookables','App\Http\Controllers\Api\BookableController')->only(['index','show']);
Route::get('/bookables/{bookable}/availability','App\Http\Controllers\Api\BookableAvailabilityController')
    ->name('bookables.availability.show');

Route::get('/bookables/{bookable}/reviews','App\Http\Controllers\Api\BookableReviewController')
    ->name('bookables.review.index');

Route::get('/bookables/{bookable}/price','App\Http\Controllers\Api\BookablePriceController')
    ->name('bookables.price.show');

Route::get('/booking-by-review/{reviewkey}', 'App\Http\Controllers\Api\BookingByReviewController')
    ->name('booking.by-review.show');

Route::post('/checkout','App\Http\Controllers\Api\CheckoutController')->name('checkout');
Route::apiResource('/reviews', 'App\Http\Controllers\Api\ReviewController')->only(['show','store']);
