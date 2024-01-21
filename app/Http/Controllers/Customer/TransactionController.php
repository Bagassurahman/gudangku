<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\TransactionHistory;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = TransactionHistory::where('user_id', '=', auth()->user()->id)->get();

        return view('customer.transactions.index', compact('transactions'));
    }
}
