<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $startDate = date('Y-m-01');
        $endDate = date('Y-m-t');

        $totalPembelianPerBulan = DB::table('purchase_of_materials_details')
            ->join('purchases', 'purchases.id', '=', 'purchase_of_materials_details.purchase_id')
            ->select(DB::raw('DATE_FORMAT(purchases.po_date, "%Y-%m") as month'), DB::raw('SUM(total) as total_pembelian'))
            ->whereBetween('purchases.po_date', [$startDate, $endDate])
            ->groupBy(DB::raw('DATE_FORMAT(purchases.po_date, "%Y-%m")'))
            ->get();

        dd($totalPembelianPerBulan);

        return view('home');
    }
}
