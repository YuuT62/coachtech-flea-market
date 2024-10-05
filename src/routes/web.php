<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\ManagementController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [ItemController::class, 'index']);
Route::get('/search', [ItemController::class, 'search']);
Route::get('/item/{item_id}', [ItemController::class, 'item']);

Route::middleware('verified')->group(function () {
    Route::get('/mypage', [UserController::class, 'mypage']);
    Route::get('/mypage/profile', [UserController::class, 'edit']);
    Route::post('mypage/profile/update', [UserController::class, 'update']);
    Route::post('/item/comment', [ItemController::class, 'comment']);
    Route::post('/item/comment/delete', [ItemController::class, 'delete']);
    Route::post('/favorite', [ItemController::class, 'favorite'])->name('item.favorite');
    Route::get('/sell', [ItemController::class, 'sell']);
    Route::post('/sell', [ItemController::class, 'add']);
    Route::get('/purchase/{item_id}', [ItemController::class, 'purchaseForm']);
    Route::get('/purchase/address/{item_id}', [ItemController::class, 'address']);
    Route::post('/purchase/address/destination/{item_id}', [ItemController::class, 'destination']);

    Route::get('/purchase/success/submit/{session_id}/{item_id}/{address_id}/{payment_method_id}', [StripeController::class, 'success']);
    Route::get('/purchase/cancel/submit', [StripeController::class, 'cancel']);
});

Route::group(['middleware' => ['auth','can:admin']], function () {
    Route::get('/management', [ManagementController::class, 'management']);
    Route::post('/user/delete', [ManagementController::class, 'delete']);
    Route::post('/email', [ManagementController::class, 'send']);
});