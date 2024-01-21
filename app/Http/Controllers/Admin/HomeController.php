<?php

namespace App\Http\Controllers\Admin;

use App\Deposit;
use App\Distribution;
use App\Event;
use App\MaterialData;
use App\Outlet;
use App\Product;
use App\Request;
use App\Riche;
use App\Transaction;
use App\TransactionDetail;
use Carbon\Carbon;
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

            $userId = Auth::user()->id;

            // Menghitung $totalPembelian
            $totalPembelianResult = DB::table('purchase_of_materials_details')
                ->join('purchase_of_materials', 'purchase_of_materials.id', '=', 'purchase_of_materials_details.purchase_of_materials_id')
                ->select(DB::raw('DATE_FORMAT(purchase_of_materials.po_date, "%Y-%m") as month'), DB::raw('SUM(total) as total_pembelian'))
                ->whereBetween('purchase_of_materials.po_date', [$startDate, $endDate])
                ->groupBy(DB::raw('DATE_FORMAT(purchase_of_materials.po_date, "%Y-%m")'))
                ->first();

            $totalPembelian = $totalPembelianResult ? $totalPembelianResult->total_pembelian : 0;

            // Menghitung $totalBiaya
            $totalBiayaResult = DB::table('cash_journal_details')
                ->join('cash_journals', 'cash_journals.id', '=', 'cash_journal_details.cash_journal_id')
                ->select(DB::raw('SUM(cash_journal_details.debit) as total_biaya'))
                ->whereBetween('cash_journals.date', [$startDate, $endDate])
                ->first();

            $totalBiaya = $totalBiayaResult ? $totalBiayaResult->total_biaya : 0;

            // Menghitung $totalOmset
            $totalOmsetResult = DB::table('distribution_details')
                ->join('distributions', 'distributions.id', '=', 'distribution_details.distribution_id')
                ->select(DB::raw('DATE_FORMAT(distributions.distribution_date, "%Y-%m") as month'), DB::raw('SUM(total) as total_omset'))
                ->whereBetween('distributions.distribution_date', [$startDate, $endDate])
                ->where('warehouse_id', $userId)
                ->groupBy(DB::raw('DATE_FORMAT(distributions.distribution_date, "%Y-%m")'))
                ->first();

            $totalOmset = $totalOmsetResult ? $totalOmsetResult->total_omset : 0;

            // Menghitung $margin
            $margin = $totalOmset - $totalPembelian;

            // Menghitung $persentaseMargin
            $persentaseMargin = ($totalOmset != 0) ? round(($margin / $totalOmset) * 100) : 0;

            // Mengambil data $inventories
            $inventories = MaterialData::with(['inventories' => function ($query) use ($userId) {
                $query->where('warehouse_id', $userId);
            }])->limit(5)->get();

            // Mengambil data $requests
            $requests = Request::where('warehouse_id', Auth::user()->id)->where('status', "pending")->limit(5)->get();

            // dd($totalPembelianPerBulan[0]->total_pembelian);
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

            if (empty($totalOmset) || empty($totalPembelian) || !isset($totalPembelian[0]->total_pembelian)) {
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
                ->limit(10)->get();

            $depo = Deposit::where('deposit_date', Carbon::today())
                ->where('status', 'success')
                ->sum('amount');

            $dateRiche = Carbon::createFromFormat('Y-m-d', Carbon::today()->format('Y-m') . '-01');
            $monthYear = $dateRiche->format('Y-m');


            $riche = DB::table('riches')
                ->where('date', $monthYear)
                ->sum('sub_total');

            $debt = DB::table('debts')
                ->whereBetween('date', [$startDate, $endDate])

                ->sum('amount');

            $deposits = Deposit::where('deposit_date', Carbon::today())
                ->where('status', 'success')
                ->get();
        } else if ($user === 'Customer') {
            // event limit
            $events = Event::latest()->limit(4)->get();
        }


        $query = Product::leftJoin('transaction_details', function ($join) {
            $join->on('products.id', '=', 'transaction_details.product_id')
                ->where(function ($query) {
                    $query->where('transaction_details.qty', '!=', 0)
                        ->orWhereNull('transaction_details.qty');
                });
        })
            ->selectRaw('products.name, SUM(transaction_details.qty) as total_qty, SUM(transaction_details.total) as total_amount')
            ->groupBy('products.name')
            ->orderByDesc('total_qty');



        $productSales = $query->get();

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
            ->orderBy('order_date', 'desc')
            ->limit(10)
            ->get();

        $richesData = Riche::select('outlet_id', DB::raw('SUM(total) as total_wealth'))
            ->groupBy('outlet_id')
            ->get();

        $categories = [];
        $series = [];

        foreach ($richesData as $data) {
            if ($data->outlet) {
                $outletName = $data->outlet->outlet_name;
            } else {
                $outletName = 'Unknown Outlet';
            }
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
            if ($penjualan->product) {
                $labelsPt[] = $penjualan->product->name;
            } else {
                $labelsPt[] = 'Unknown Product';
            }
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

        $parsedDate = Carbon::now();

        $riches = Riche::with('outlet')
            ->where('date', $parsedDate->format('Y-m'))
            ->orderBy('total', 'desc')
            ->limit(10)
            ->get();



        $totalOmset = $totalDistributionDetails->total_distribution_details + $totalDistributionFee->total_distribution_fee;

        if (empty($totalOmset) || empty($totalPembelian) || !isset($totalPembelian[0]->total_pembelian)) {
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
            return view('home', compact('totalPembelian', 'inventories', 'totalOmset', 'requests', 'totalBiaya', 'margin', 'persentaseMargin'));
        } else if ($user === 'Outlet') {
            $products = Product::all();

            $userAgent = $_SERVER['HTTP_USER_AGENT'];

            $mobileKeywords = ['Mobile', 'Android', 'iPhone', 'iPad', 'BlackBerry', 'Windows Phone'];

            $isMobile = false; // Initialize with false

            foreach ($mobileKeywords as $keyword) {
                if (stripos($userAgent, $keyword) !== false) {
                    $isMobile = true;
                    break;
                }
            }


            return view('home', compact('products', 'isMobile'));
        } else if ($user === 'Finance') {
            return view('home', compact('totalOmset', 'totalBiaya', 'totalPembelian', 'margin', 'persentaseMargin', 'transactions', 'depo', 'debt', 'riche', 'deposits'));
        } else if ($user === 'Customer') {
            return view('home', compact('events'));
        }


        return view('home', compact('penjualanPerBulan', 'labelsPt', 'dataPt', 'labelsOt', 'dataOt', 'outlets', 'transactions', 'categories', 'series', 'totalOmset', 'totalBiaya', 'totalPembelian', 'margin', 'persentaseMargin', 'riches', 'productSales'));
    }
}
