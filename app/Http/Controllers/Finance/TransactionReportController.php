<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $transactions = DB::table('transactions')
            ->selectRaw('MONTH(transactions.order_date) as month, SUM(transactions.total) as total_transaction')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        foreach ($transactions as $transaction) {
            $monthName = Carbon::create()->month($transaction->month)->format('F');
            $transaction->month_name = $monthName;
        }


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
            ->selectRaw('transactions.*, outlets.outlet_name')
            ->whereMonth('transactions.order_date', $month)
            ->where('transactions.outlet_id', $outletId)
            ->orderBy('transactions.order_date')
            ->get();


        return view('finance.transaction-report.show', compact('transactions'));
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
        //
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
            ->get();


        foreach ($transactions as $transaction) {
            $monthName = Carbon::parse('2000-' . $transaction->month . '-01')->format('F');
            $transaction->month_name = $monthName;
        }


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









        return view('finance.transaction-report.detail', compact('transactions', 'transactionDetails'));
    }
}
