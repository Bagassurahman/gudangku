<?php

namespace App\Http\Controllers\Admin;

use App\MaterialData;
use App\Outlet;
use App\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController
{
    public function index()
    {
        if (Auth::user()->roles[0]->title == 'Gudang') {
            $startDate = date('Y-m-01');
            $endDate = date('Y-m-t');

            $userId = Auth::id();
            $totalPembelianPerBulan = DB::table('purchase_of_materials_details')
                ->join('purchase_of_materials', 'purchase_of_materials.id', '=', 'purchase_of_materials_details.purchase_of_materials_id')
                ->select(DB::raw('DATE_FORMAT(purchase_of_materials.po_date, "%Y-%m") as month'), DB::raw('SUM(total) as total_pembelian'))
                ->whereBetween('purchase_of_materials.po_date', [$startDate, $endDate])
                ->groupBy(DB::raw('DATE_FORMAT(purchase_of_materials.po_date, "%Y-%m")'))
                ->get();


            $inventories = MaterialData::with(['inventories' => function ($query) use ($userId) {
                $query->where('warehouse_id', $userId);
            }])->get();
        }

        $outlets = Outlet::all();

        if (Auth::user()->roles[0]->title == 'Gudang') {
            return view('home', compact('totalPembelianPerBulan', 'inventories'));
        } else if (Auth::user()->roles[0]->title = 'Outlet') {
            $products = Product::all();

            return view('home', compact('products'));
        }

        return view('home', compact('outlets'));
    }
}
