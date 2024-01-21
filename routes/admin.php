<?php

use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

    // Gudang
    Route::resource('manajemen-gudang', 'WarehouseManagementController');

    // Outlet
    Route::resource('manajemen-outlet', 'OutletManagementController');

    // Data Satuan
    Route::resource('data-satuan', 'UnitDataController');

    // Data Bahan
    Route::resource('data-bahan', 'MaterialDataController');

    // Biaya
    Route::resource('biaya', 'CostController');

    // Produk
    Route::resource('produk', 'ProductController');

    Route::resource('persediaan-outlet', 'InventoryOutletController');

    Route::post('persediaan-outlet-edit', 'InventoryOutletController@update')->name('update-persediaan');

    Route::get('laporan-aktivitas', 'ActivityLogController@index')->name('log.index');

    Route::resource('event', 'EventController');

    Route::resource('reward', 'RewardController');
});
