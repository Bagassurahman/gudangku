<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Reward;
use Illuminate\Http\Request;

class RewardController extends Controller
{
    public function index()
    {
        $rewards = Reward::paginate(10);

        return view('customer.rewards.index', compact('rewards'));
    }

    public function show($slug)
    {
        $reward = Reward::where('slug', $slug)->firstOrFail();

        return view('customer.rewards.show', compact('reward'));
    }
}
