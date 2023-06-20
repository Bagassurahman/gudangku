<?php

namespace App\Http\Controllers\Outlet;

use App\Http\Controllers\Controller;
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
        $query = DB::table('transactions')
            ->selectRaw('transactions.order_date, SUM(transactions.total) as total_transaction')
            ->groupBy('transactions.order_date')
            ->orderBy('transactions.order_date');

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
            $date = Carbon::parse($transaction->order_date)->format('d F Y');
            $transaction->order_date = $date;
        }

        return view('outlet.transaction-report.index', compact('transactions'));
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
    public function show($date)
    {
        $newDate = date('Y-m-d', strtotime($date));

        $transactions = DB::table('transactions')
            ->join('outlets', 'transactions.outlet_id', '=', 'outlets.user_id')
            ->selectRaw('transactions.order_number, transactions.id, transactions.total, outlets.outlet_name')
            ->whereDate('transactions.order_date', $newDate)
            ->orderBy('transactions.order_date')
            ->get();

        return view('outlet.transaction-report.show', compact('transactions', 'date'));
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

    public function showDetail($id)
    {

        $transactionDetails = DB::table('transaction_details')
            ->join('products', 'transaction_details.product_id', '=', 'products.id')
            ->join('transactions', 'transaction_details.transaction_id', '=', 'transactions.id')
            ->selectRaw('transaction_details.qty, transaction_details.price, products.name, transactions.*')
            ->where('transaction_details.transaction_id', $id)
            ->get();



        return view('outlet.transaction-report.detail', compact('transactionDetails'));
    }
}
