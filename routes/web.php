<?php

use App\Http\Controllers\Admin\WarehouseManagementController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::redirect('/', '/login');
Route::get('/home', function () {
    if (session('status')) {
        return redirect()->route('admin.home')->with('status', session('status'));
    }

    return redirect()->route('admin.home');
});

Auth::routes(['register' => false]);
// Admin

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('home');
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
});

Route::group(['prefix' => 'gudang', 'as' => 'warehouse.', 'namespace' => 'Warehouse', 'middleware' => ['auth']], function () {

    Route::resource('suppliers', 'SupplierController');

    Route::resource('pembelian-bahan', 'PurchaseOfMaterialController');

    Route::resource('persediaan', 'InventoryController');

    Route::resource('distribusi', 'DistributionController');

    Route::get('distribusi/{outlet_id}', 'DistributionController@show')->name('distribusi.show');

    Route::resource('laporan-pembelian', 'PurchaseReportController');
    // detail laporan
    Route::get('laporan-pembelian/{date}', 'PurchaseReportController@show')->name('laporan-pembelian.show');

    Route::resource('laporan-distribusi', 'DistributionReportController');
    // detail laporan
    Route::get('laporan-distribusi/{date}', 'DistributionReportController@show')->name('laporan-distribusi.show');
});

Route::group(['prefix' => 'outlet', 'as' => 'outlet.', 'namespace' => 'Outlet', 'middleware' => ['auth']], function () {

    Route::resource('request', 'RequestController');

    Route::resource('persediaan', 'InventoryController');
});

Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth']], function () {
    // Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
        Route::post('password', 'ChangePasswordController@update')->name('password.update');
    }
});
