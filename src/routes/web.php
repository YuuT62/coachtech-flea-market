<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\UserController;

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
Route::get('/item/{item_id}', [ItemController::class, 'item']);

Route::get('/sell', function () {
return view('.form.sell');
});

Route::get('/mypage/profile', function () {
return view('.form.profile');
});

Route::get('/purchase/address', function () {
return view('.form.destination');
});

Route::post('/favorite', [ItemController::class, 'favorite'])->name('item.favorite');




Route::middleware('auth')->group(function () {
    Route::get('/mypage', [UserController::class, 'mypage']);
    Route::get('/mypage/profile', [UserController::class, 'edit']);
    Route::post('mypage/profile/update', [UserController::class, 'update']);
    Route::post('/item/comment', [ItemController::class, 'comment']);
    Route::post('/item/comment/delete', [ItemController::class, 'delete']);
});