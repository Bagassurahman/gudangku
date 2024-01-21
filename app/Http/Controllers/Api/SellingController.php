<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Transaction;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SellingController extends Controller
{
    public function getOutletSales($id)
    {
        $transactions = DB::table('transactions')
            ->select(
                DB::raw('MONTH(order_date) as month'),
                DB::raw('COUNT(*) as transaction_count'),
                DB::raw('SUM(total) as total_earnings')
            )
            ->groupBy('month')
            ->where('outlet_id', $id)
            ->get();

        $response = [];
        foreach ($transactions as $transaction) {
            $monthNumber = $transaction->month;
            $monthName = DateTime::createFromFormat('!m', $transaction->month)->format('F');
            $response[] = [
                'month' => $monthName,
                'month_number' => $monthNumber,
                'transaction_count' => $transaction->transaction_count,
                'total_earnings' => $transaction->total_earnings
            ];
        }

        return response()->json($response);
    }

    public function getTransactionDetailsByMonth(Request $request)
    {
        $month = $request->month;

        $transactionDetails = DB::table('transaction_details')
            ->join('transactions', 'transaction_details.transaction_id', '=', 'transactions.id')
            ->join('products', 'transaction_details.product_id', '=', 'products.id')
            ->where('outlet_id', $request->outlet_id)
            ->whereMonth('transactions.order_date', $month)
            ->get();


        return response()->json($transactionDetails);
    }
}
