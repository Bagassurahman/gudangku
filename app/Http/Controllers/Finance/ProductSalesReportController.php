<?php

namespace App\Http\Controllers\Finance;

use App\ActivityLog;
use App\TransactionDetail;
use App\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Gate;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProductSalesReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        abort_if(Gate::denies('product_sales_report_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $tanggal_mulai = $request->input('tanggal_mulai');
        $tanggal_akhir = $request->input('tanggal_akhir');

        $query = Product::leftJoin('transaction_details', function ($join) use ($tanggal_mulai, $tanggal_akhir, $request) {
            $join->on('products.id', '=', 'transaction_details.product_id');
            if ($request->filled('tanggal_mulai') && $request->filled('tanggal_akhir')) {
                $tanggalMulai = $request->input('tanggal_mulai');
                $tanggalAkhir = $request->input('tanggal_akhir');

                $join->whereDate('transaction_details.created_at', '>=', $tanggalMulai)
                    ->whereDate('transaction_details.created_at', '<=', $tanggalAkhir);
            } elseif ($request->filled('tanggal_mulai')) {
                $tanggalMulai = $request->input('tanggal_mulai');

                $join->whereDate('transaction_details.created_at', '>=', $tanggalMulai);
            }
        })
            ->selectRaw('products.name,
                SUM(CASE WHEN transaction_details.qty IS NULL OR transaction_details.qty = 0 THEN 0 ELSE transaction_details.qty END) as total_qty,
                SUM(CASE WHEN transaction_details.qty IS NULL OR transaction_details.qty = 0 THEN 0 ELSE transaction_details.total END) as total_amount')
            ->groupBy('products.name');

        // Conditional orderBy clauses
        $productSales = $query->orderByDesc('total_qty')
            ->orderBy('products.name', 'asc')
            ->get();


        // foreach ($productSales as $productSales) {
        //     $tot = $productSales->total_qty;
        // }
        // dd($tot);

        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'action' => 'Mengakses menu laporan penjualan produk',
            'details' => 'Mengakses menu laporan penjualan produk'
        ]);

        return view('finance.product-sales-report.index', compact('productSales', 'tanggal_mulai', 'tanggal_akhir'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
