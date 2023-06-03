<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Transaction;
use Illuminate\Http\Request;

class SellingController extends Controller
{
    public function getOutletSales($id)
    {
        $sales = Transaction::where('outlet_id', $id)->with(['transactionDetails', 'transactionDetails.product'])->get();

        return response()->json($sales);
    }
}
