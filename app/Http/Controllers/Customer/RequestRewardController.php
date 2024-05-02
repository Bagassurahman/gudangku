<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RequestRewardController extends Controller
{
    public function index()
    {
        $requests = auth()->user()->request_rewards()->paginate(10);

        return view('customer.request-rewards.index', compact('requests'));
    }
}
