<?php

use App\Http\Controllers\Api\InventoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\SellingController;
use Illuminate\Support\Facades\Route;

Route::get('/outlet/{id}/inventory', [InventoryController::class, 'getOutletInventory']);
Route::get('/outlet/{id}/sales', [SellingController::class, 'getOutletSales']);
Route::get('/transaction/details', [SellingController::class, 'getTransactionDetailsByMonth']);
Route::get('/products/{id}', [ProductController::class, 'index']);
