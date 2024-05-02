<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PointController extends Controller
{
    public function index()
    {
        $points = auth()->user()->points()->paginate(10);

        return view('customer.points.index', compact('points'));
    }
}
