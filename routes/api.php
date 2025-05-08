<?php

use App\Http\Controllers\Api\InventoryController;
use App\Http\Controllers\Api\MemberController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\SellingController;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Http\Request;

// Auth::routes();

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::post('/register', [AuthController::class, 'register']);
Route::middleware('auth:api')->get('/profile', function (Request $request) {
    return response()->json([
        'success' => true,
        'user' => $request->user()
    ]);
});



Route::get('/outlet/{id}/inventory', [InventoryController::class, 'getOutletInventory']);
Route::get('/outlet/{id}/sales', [SellingController::class, 'getOutletSales']);
Route::get('/transaction/details', [SellingController::class, 'getTransactionDetailsByMonth']);
Route::get('/products/{id}', [ProductController::class, 'index']);

Route::get('/get-member/{phoneNumber}', [MemberController::class, 'getMemberByPhoneNumber']);
