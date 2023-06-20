<?php

namespace App\Http\Controllers\Admin;

use App\Distribution;
use App\MaterialData;
use App\Outlet;
use App\Product;
use App\Request;
use App\Riche;
use App\Transaction;
use App\TransactionDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController
{
    public function index()
    {

        $startDate = date('Y-m-01');
        $endDate = date('Y-m-t');
        $user = Auth::user()->roles[0]->title;


        if ($user === 'Gudang') {

            $userId = Auth::id();

            $totalPembelianPerBulan = DB::table('purchase_of_materials_details')
                ->join('purchase_of_materials', 'purchase_of_materials.id', '=', 'purchase_of_materials_details.purchase_of_materials_id')
                ->select(DB::raw('DATE_FORMAT(purchase_of_materials.po_date, "%Y-%m") as month'), DB::raw('SUM(total) as total_pembelian'))
                ->whereBetween('purchase_of_materials.po_date', [$startDate, $endDate])
                ->groupBy(DB::raw('DATE_FORMAT(purchase_of_materials.po_date, "%Y-%m")'))
                ->where('warehouse_id', $userId)
                ->get();

            $totalOmset =
                DB::table('distribution_details')
                ->join('distributions', 'distributions.id', '=', 'distribution_details.distribution_id')
                ->select(DB::raw('DATE_FORMAT(distributions.distribution_date, "%Y-%m") as month'), DB::raw('SUM(total) as total_omset'))
                ->whereBetween('distributions.distribution_date', [$startDate, $endDate])
                ->where('warehouse_id', $userId)

                ->groupBy(DB::raw('DATE_FORMAT(distributions.distribution_date, "%Y-%m")'))
                ->get();

            $inventories = MaterialData::with(['inventories' => function ($query) use ($userId) {
                $query->where('warehouse_id', $userId);
            }])->limit(5)->get();

            $requests = Request::where('warehouse_id', Auth::user()->id)->where('status', "pending")->limit(5)->get();
        } else if ($user === 'Finance') {


            $totalDistributionDetails = DB::table('distribution_details')
                ->join('distributions', 'distributions.id', '=', 'distribution_details.distribution_id')
                ->select(DB::raw('SUM(total) as total_distribution_details'))
                ->whereBetween('distributions.distribution_date', [$startDate, $endDate])
                ->first();


            $totalDistributionFee = DB::table('distributions')
                ->select(DB::raw('SUM(fee) as total_distribution_fee'))
                ->whereBetween('distributions.distribution_date', [$startDate, $endDate])
                ->first();

            $totalBiaya = DB::table('cash_journal_details')
                ->join('cash_journals', 'cash_journals.id', '=', 'cash_journal_details.cash_journal_id')
                ->select(DB::raw('SUM(cash_journal_details.debit) as total_biaya'))
                ->whereBetween('cash_journals.date', [$startDate, $endDate])
                ->first();

            $totalPembelian =
                DB::table('purchase_of_materials_details')
                ->join('purchase_of_materials', 'purchase_of_materials.id', '=', 'purchase_of_materials_details.purchase_of_materials_id')
                ->select(DB::raw('DATE_FORMAT(purchase_of_materials.po_date, "%Y-%m") as month'), DB::raw('SUM(total) as total_pembelian'))
                ->whereBetween('purchase_of_materials.po_date', [$startDate, $endDate])
                ->groupBy(DB::raw('DATE_FORMAT(purchase_of_materials.po_date, "%Y-%m")'))
                ->get();



            $totalOmset = $totalDistributionDetails->total_distribution_details + $totalDistributionFee->total_distribution_fee;

            if (empty($totalOmset)) {
                $margin = 0; // Atau nilai default yang sesuai dengan kebutuhan Anda
            } else {
                $margin = $totalOmset - $totalPembelian[0]->total_pembelian;
            }



            if ($totalOmset != 0) {
                $persentaseMargin = round(($margin / $totalOmset) * 100);
            } else {
                $persentaseMargin = 0;
            }


            $transactions = Transaction::with('outlet')
                ->whereBetween('order_date', [$startDate, $endDate])
                ->get();
        }


        $outlets = Outlet::all();

        $penjualanTerlaris = TransactionDetail::select('product_id', DB::raw('SUM(qty) as total_qty'))
            ->groupBy('product_id')
            ->orderByDesc('total_qty')
            ->limit(10)
            ->get();

        $outletTerlaris = Transaction::join('transaction_details', 'transactions.id', '=', 'transaction_details.transaction_id')
            ->join('outlets', 'transactions.outlet_id', '=', 'outlets.user_id')
            ->select('outlets.outlet_name', DB::raw('SUM(transaction_details.qty) as total_qty'))
            ->groupBy('transactions.outlet_id', 'outlets.outlet_name')
            ->orderByDesc('total_qty')
            ->limit(5)
            ->get();


        $penjualanPerBulan = TransactionDetail::select(
            DB::raw('YEAR(created_at) AS year'),
            DB::raw('MONTH(created_at) AS month'),
            DB::raw('SUM(qty) AS total_penjualan')
        )
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        $transactions = Transaction::with('outlet')
            ->get();

        $richesData = Riche::select('outlet_id', DB::raw('SUM(total) as total_wealth'))
            ->groupBy('outlet_id')
            ->get();

        $categories = [];
        $series = [];

        foreach ($richesData as $data) {
            $outletName = $data->outlet->outlet_name; // Assuming there is an "Outlet" model with a "name" attribute
            $totalWealth = $data->total_wealth;

            $categories[] = $outletName;
            $series[] = $totalWealth;
        }

        // dd($series);
        $labelsPt = [];
        $dataPt = [];

        $labelsOt = [];
        $dataOt = [];

        foreach ($penjualanTerlaris as $penjualan) {
            $labelsPt[] = $penjualan->product->name;
            $dataPt[] = intval($penjualan->total_qty);
        }

        foreach ($outletTerlaris as $outlet) {
            $labelsOt[] = $outlet->outlet_name;
            $dataOt[] = intval($outlet->total_qty);
        }

        $totalDistributionDetails = DB::table('distribution_details')
            ->join('distributions', 'distributions.id', '=', 'distribution_details.distribution_id')
            ->select(DB::raw('SUM(total) as total_distribution_details'))
            ->whereBetween('distributions.distribution_date', [$startDate, $endDate])
            ->first();


        $totalDistributionFee = DB::table('distributions')
            ->select(DB::raw('SUM(fee) as total_distribution_fee'))
            ->whereBetween('distributions.distribution_date', [$startDate, $endDate])
            ->first();

        $totalBiaya = DB::table('cash_journal_details')
            ->join('cash_journals', 'cash_journals.id', '=', 'cash_journal_details.cash_journal_id')
            ->select(DB::raw('SUM(cash_journal_details.debit) as total_biaya'))
            ->whereBetween('cash_journals.date', [$startDate, $endDate])
            ->first();

        $totalPembelian =
            DB::table('purchase_of_materials_details')
            ->join('purchase_of_materials', 'purchase_of_materials.id', '=', 'purchase_of_materials_details.purchase_of_materials_id')
            ->select(DB::raw('DATE_FORMAT(purchase_of_materials.po_date, "%Y-%m") as month'), DB::raw('SUM(total) as total_pembelian'))
            ->whereBetween('purchase_of_materials.po_date', [$startDate, $endDate])
            ->groupBy(DB::raw('DATE_FORMAT(purchase_of_materials.po_date, "%Y-%m")'))
            ->get();



        $totalOmset = $totalDistributionDetails->total_distribution_details + $totalDistributionFee->total_distribution_fee;

        if (empty($totalOmset)) {
            $margin = 0; // Atau nilai default yang sesuai dengan kebutuhan Anda
        } else {
            $margin = $totalOmset - $totalPembelian[0]->total_pembelian;
        }



        if ($totalOmset != 0) {
            $persentaseMargin = round(($margin / $totalOmset) * 100);
        } else {
            $persentaseMargin = 0;
        }

        if ($user === 'Gudang') {
            return view('home', compact('totalPembelianPerBulan', 'inventories', 'totalOmset', 'requests'));
        } else if ($user === 'Outlet') {
            $products = Product::all();

            return view('home', compact('products'));
        } else if ($user === 'Finance') {
            return view('home', compact('totalOmset', 'totalBiaya', 'totalPembelian', 'margin', 'persentaseMargin', 'transactions'));
        }

        return view('home', compact('penjualanPerBulan', 'labelsPt', 'dataPt', 'labelsOt', 'dataOt', 'outlets', 'transactions', 'categories', 'series', 'totalOmset', 'totalBiaya', 'totalPembelian', 'margin', 'persentaseMargin'));
    }
}
