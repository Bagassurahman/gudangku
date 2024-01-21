<?php

namespace App\Http\Controllers\Finance;

use App\ActivityLog;
use App\Http\Controllers\Controller;
use App\Inventory;
use App\MaterialData;
use App\Product;
use App\ProductDetail;
use App\Transaction;
use App\UnitData;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert as SweetAlert;

class TransactionReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $monthNumber = $request->input('month_number');

        $query = DB::table('transactions')
            ->selectRaw('MONTH(transactions.order_date) as month, SUM(transactions.total) as total_transaction')
            ->groupBy('month')
            ->orderBy('month');

        if ($request->filled('tanggal_mulai') && $request->filled('tanggal_akhir')) {
            $tanggalMulai = $request->input('tanggal_mulai');
            $tanggalAkhir = $request->input('tanggal_akhir');

            $query->whereDate('transactions.order_date', '>=', $tanggalMulai)
                ->whereDate('transactions.order_date', '<=', $tanggalAkhir);
        } elseif ($request->filled('tanggal_mulai')) {
            $tanggalMulai = $request->input('tanggal_mulai');

            $query->whereDate('transactions.order_date', '>=', $tanggalMulai);
        }

        $transactions = $query->get();

        foreach ($transactions as $transaction) {
            $monthName = Carbon::create()->month($transaction->month)->format('F');
            $transaction->month_name = $monthName;
        }

        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'action' => 'Mengakses menu laporan transaksi',
            'details' => 'Mengakses menu laporan transaksi'
        ]);

        return view('finance.transaction-report.index', compact('transactions'));
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($month, $outletId)
    {
        $transactions = DB::table('transactions')
            ->join('outlets', 'transactions.outlet_id', '=', 'outlets.user_id')
            ->selectRaw('transactions.order_date, outlets.outlet_name, SUM(transactions.total) AS total_sum')
            ->whereMonth('transactions.order_date', $month)
            ->where('transactions.outlet_id', $outletId)
            ->groupBy('transactions.order_date', 'outlets.outlet_name')
            ->orderBy('transactions.order_date')
            ->get();

        // log create
        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'action' => 'Mengakses detail menu laporan transaksi',
            'details' => 'Mengakses detail menu laporan transaksi'

        ]);


        return view('finance.transaction-report.show-detail', compact('transactions', 'month', 'outletId'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $transaction = Transaction::with('transactionDetails')->findOrFail($id);


        foreach ($transaction->transactionDetails as $transactionDetail) {
            $productDetail = ProductDetail::where('product_id', $transactionDetail->product_id)->first();

            $productDetails = ProductDetail::where('product_id', $transactionDetail->product_id)->get();

            foreach ($productDetails as $productDetail) {
                $material_data_id = $productDetail->material_id;
                $dose = $productDetail->dose;


                $inventory = Inventory::where('material_data_id', $material_data_id)
                    ->where('outlet_id', $transaction->outlet_id)
                    ->first();


                if ($inventory) {
                    $exit_amount = $dose * $transactionDetail->qty;
                    $inventory->update([
                        'exit_amount' => $inventory->exit_amount - $exit_amount,
                        'remaining_amount' => $inventory->remaining_amount + $exit_amount
                    ]);
                } else {
                    SweetAlert::error('Gagal', 'Data gagal dihapus');
                }
            }
        }

        $transaction->delete();

        // log
        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'action' => 'Menghapus data transaksi',
            'details' => 'Menghapus data transaksi'
        ]);

        SweetAlert::success('Berhasil', 'Data berhasil dihapus');

        return redirect()->back();
    }

    public function showOutlet($month)
    {
        $transactions = DB::table('transactions')
            ->selectRaw('MONTH(transactions.order_date) as month, SUM(transactions.total) as total_transaction, transactions.outlet_id, outlets.outlet_name, users.warehouse_name')
            ->join('outlets', 'transactions.outlet_id', '=', 'outlets.user_id')
            ->join('users', 'outlets.warehouse_id', '=', 'users.id')
            ->whereMonth('transactions.order_date', $month)
            ->groupBy('transactions.outlet_id', 'month', 'outlets.outlet_name', 'users.warehouse_name')
            ->orderBy('month')
            ->orderBy('total_transaction', 'desc')
            ->get();


        foreach ($transactions as $transaction) {
            $monthName = Carbon::parse('2000-' . $transaction->month . '-01')->format('F');
            $transaction->month_name = $monthName;
        }

        // log
        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'action' => 'Mengakses detail data transaksi',
            'details' => 'Mengakses detail data transaksi'
        ]);

        return view('finance.transaction-report.outlet', compact('transactions'));
    }

    public function showDate($date, $outletId)
    {
        $newDate = date('Y-m-d', strtotime($date));


        $transactions = DB::table('transactions')
            ->join('outlets', 'transactions.outlet_id', '=', 'outlets.user_id')
            ->selectRaw('transactions.order_number, transactions.id, transactions.total, outlets.outlet_name')
            ->whereDate('transactions.order_date', $newDate)
            ->where('outlet_id', $outletId)
            ->orderBy('transactions.order_date')
            ->get();



        return view('finance.transaction-report.show-date', compact('transactions'));
    }

    public function showDetail($id)
    {

        $transactions = Transaction::findOrFail($id);

        $transactionDetails = DB::table('transaction_details')
            ->join('products', 'transaction_details.product_id', '=', 'products.id')
            ->join('transactions', 'transaction_details.transaction_id', '=', 'transactions.id')
            ->select('products.name', 'products.id as product_id', DB::raw('(SELECT qty FROM transaction_details WHERE transaction_details.product_id = products.id AND transaction_details.transaction_id = transactions.id LIMIT 1) as qty'), 'transactions.*', DB::raw('GROUP_CONCAT(transaction_details.id) as transaction_detail_ids'))
            ->where('transaction_details.transaction_id', $id)
            ->groupBy('products.id', 'transactions.id')
            ->get();
            
        if (isset($transactionDetails) && !$transactionDetails->isEmpty()) {
            foreach ($transactionDetails as $transactionDetail) {
                $transactionDetail->product_details = DB::table('transaction_details')
                    ->join('products', 'transaction_details.product_id', '=', 'products.id')
                    ->join('product_details', 'products.id', '=', 'product_details.product_id')
                    ->join('material_data', 'product_details.material_id', '=', 'material_data.id')
                    ->join('unit_data', 'material_data.unit_id', '=', 'unit_data.id')
                    ->select('transaction_details.*', 'products.name', 'material_data.name as material_name', 'product_details.*', 'unit_data.outlet_unit')
                    ->where('transaction_details.transaction_id', $id)
                    ->where('transaction_details.product_id', $transactionDetail->product_id)
                    ->get();
            }
        } else {
            $transactionDetail->product_details = '-';
        }


        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'action' => 'Mengakses detail data transaksi',
            'details' => 'Mengakses detail data transaksi'
        ]);



        return view('finance.transaction-report.detail', compact('transactions', 'transactionDetails'));
    }
}
