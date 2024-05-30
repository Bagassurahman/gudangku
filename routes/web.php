<?php

use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\WarehouseManagementController;
use App\Transaction;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::redirect('/', '/login');
Route::get('/home', function () {
    if (session('status')) {
        return redirect()->route('admin.home')->with('status', session('status'));
    }

    return redirect()->route('admin.home');
});

Route::get('/dashboard', [HomeController::class, 'index'])
    ->name('dashboard')
    ->middleware('auth');

Route::get('tes', function () {
    $userAgent = $_SERVER['HTTP_USER_AGENT'];

    $mobileKeywords = ['Mobile', 'Android', 'iPhone', 'iPad', 'BlackBerry', 'Windows Phone'];

    $isMobile = false; // Initialize with false

    foreach ($mobileKeywords as $keyword) {
        if (stripos($userAgent, $keyword) !== false) {
            $isMobile = true;
            break;
        }
    }

    dd($isMobile);
});




Auth::routes();


Route::group(['prefix' => 'gudang', 'as' => 'warehouse.', 'namespace' => 'Warehouse', 'middleware' => ['auth']], function () {

    Route::resource('hutang-piutang', 'DebtController');

    Route::resource('setoran', 'DepositController');

    // Route::resource('setting-profil', 'ProfilSetingController');

    Route::resource('suppliers', 'SupplierController');

    Route::resource('pembelian-bahan', 'PurchaseOfMaterialController');

    Route::resource('persediaan', 'InventoryController');

    Route::resource('persediaan-outlet', 'InventoryOutletController');

    Route::resource('penjualan-outlet', 'DataSalesOutletController');

    Route::resource('distribusi', 'DistributionController');
    Route::get('distribusi/{outlet_id}', 'DistributionController@show')->name('distribusi.show');
    Route::get('distribusi/detail/{id}', 'DistributionController@detail')->name('distribusi.detail');


    Route::resource('data-request-bahan', 'RequestDistributionController');

    Route::get('check-stock', 'DistributionController@checkStock')->name('check-stock');
    Route::get('reduce-stock', 'DistributionController@reduceStock')->name('reduce-stock');
    Route::get('increase-stock', 'DistributionController@increaseStock')->name('increase-stock');


    Route::resource('laporan-pembelian', 'PurchaseReportController');
    // detail laporan
    Route::get('laporan-pembelian/{date}', 'PurchaseReportController@show')->name('laporan-pembelian.show');
    Route::get('laporan-pembelian/detail/{id}', 'PurchaseReportController@detail')->name('laporan-pembelian.detail');

    Route::resource('laporan-distribusi', 'DistributionReportController');
    Route::get('laporan-distribusi/show-date/{month}', 'DistributionReportController@showDate')->name('laporan-distribusi.show-date');

    Route::get('laporan-distribusi/{month}/detail', 'DistributionReportController@showMonth')->name('distribusi.showMonth');
    // detail laporan
    // Route::get('laporan-distribusi/{date}', 'DistributionReportController@show')->name('laporan-distribusi.show');

    Route::post('data-request-bahan/reject', 'RequestDistributionController@reject')->name('request.reject');

    Route::get('data-penukaran-poin', 'RequestRewardController@index')->name('request-reward.index');
    Route::get('data-penukaran-poin/{id}', 'RequestRewardController@show')->name('request-reward.show');
    Route::post('data-penukaran-poin/approve', 'RequestRewardController@approve')->name('request-reward.approve');
    Route::post('data-penukaran-poin/reject', 'RequestRewardController@reject')->name('request-reward.reject');
});

Route::group(['prefix' => 'outlet', 'as' => 'outlet.', 'namespace' => 'Outlet', 'middleware' => ['auth']], function () {
    Route::resource('laporan-penjualan', 'TransactionReportController');
    Route::get('laporan-penjualan/show-date/{month}', 'TransactionReportController@showDate')->name('transaction.show.date');
    Route::get('/transaction/{id}', 'TransactionReportController@showDetail')->name('transaction.detail');

    Route::resource('setoran', 'DepositController');
    Route::post('setoran/{id}', 'DepositController@store')->name('setoran.store');

    Route::resource('request', 'RequestController');

    Route::resource('persediaan', 'InventoryController');

    Route::get('detail-produk', 'ProductController@getProductDetails')->name('detail-produk');
    // stok
    Route::get('stok-produk', 'ProductController@getProductStockByMaterial')->name('stok-produk');

    Route::get('decrease-stok-produk', 'ProductController@reduceProductStockByMaterial')->name('decrease-stok-produk');

    Route::get('increase-stok-produk', 'ProductController@increaseProductStockByMaterial')->name('increase-stok-produk');

    Route::get('get-stok', 'ProductController@getStockByInventory')->name('get-stok');


    Route::resource('transaction', 'TransactionController');

    Route::resource('jurnal-kas', 'CashJournalController');

    Route::resource('distribusi', 'DistributionController');
    Route::get('/distribusi/accept/{id}', 'DistributionController@accept')->name('distribusi.accept');

    Route::get('/data-penukaran-poin', 'RequestRewardController@index')->name('request-reward.index');
    Route::get('/data-penukaran-poin/{id}', 'RequestRewardController@show')->name('request-reward.show');
    Route::put('/data-penukaran-poin/{id}', 'RequestRewardController@update')->name('request-reward.update');
});
Route::group(['prefix' => 'finance', 'as' => 'finance.', 'namespace' => 'Finance', 'middleware' => ['auth']], function () {
    Route::resource('laporan-distribusi', 'DistributionReportController');
    Route::get('/distribution/{date}/detail/{warehouseId}', 'DistributionReportController@showDetail')->name('distribution.detail');
    Route::get('/distribution/{date}/detail-bahan/{outletId}', 'DistributionReportController@showMaterial')->name('distribution.detailBahan');


    Route::resource('laporan-pembelian', 'PurchaseOfMaterialReportController');
    Route::get('/purchase/{date}/detail/{warehouseId}', 'PurchaseOfMaterialReportController@showDetail')->name('purchase.detail');

    Route::resource('laporan-setoran', 'DepositReportController');
    Route::get('/deposit/{date}/detail/{accountNumber}', 'DepositReportController@showDetail')->name('deposit.detail');

    Route::resource('laporan-jurnal-kas', 'CashJournalReportController');
    Route::get('/cash-journal/{date}/detail/{outletId}', 'CashJournalReportController@showDetail')->name('cash-journal.detail');

    Route::resource('laporan-penjualan', 'TransactionReportController');
    Route::get('/transaction/show/outlet/{month}', 'TransactionReportController@showOutlet')->name('transaction.show-outlet');
    Route::get('/transaction/{month}/{outletId}', 'TransactionReportController@show')->name('transaction.show-month');
    Route::get('/transaction/show-date/{date}/{outletId}', 'TransactionReportController@showDate')->name('transaction.show-date');

    Route::get('/transaction/{id}', 'TransactionReportController@showDetail')->name('transaction.detail');

    // Laporan Penjualan Product
    Route::resource('laporan-penjualan-product', 'ProductSalesReportController');

    // Laporan Penjualan Product
    Route::resource('laporan-penjualan-bahan', 'MaterialSalesReportController');

    Route::resource('laporan-kekayaan-outlet', 'RichesReportController');
    Route::get('/laporan-kekayaan-outlet/{date}/{id}', 'RichesReportController@show')->name('finance.laporan-kekayaan-outlet.showDetail');

    Route::resource('setoran', 'DepositController');
    Route::resource('hutang-piutang', 'DebtController');
});

Route::group(['prefix' => 'customer', 'as' => 'customer.', 'namespace' => 'Customer', 'middleware' => ['auth']], function () {
    Route::get('event', 'EventController@index')->name('event.index');
    Route::get('event/{slug}', 'EventController@show')->name('event.show');

    Route::get('hadiah', 'RewardController@index')->name('reward.index');
    Route::get('hadiah/{slug}', 'RewardController@show')->name('reward.show');

    Route::post('hadiah/{id}', 'RewardController@redeem')->name('reward.redeem');

    Route::get('poin', 'PointController@index')->name('point.index');

    Route::get('transaksi-saya', 'TransactionController@index')->name('transaction.index');

    Route::get('riwayat-penukaran-poin', 'RequestRewardController@index')->name('request-reward.index');
});

Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth']], function () {
    // Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
        Route::post('password', 'ChangePasswordController@update')->name('password.update');
    }
});


Route::get('/print-transaksi/{id}', function ($id) {
    $transaction = Transaction::find($id);

    return view('print.transaction', compact('transaction'));
})->name('print.transaction');
