<?php

namespace App\Http\Controllers\Finance;

use App\ActivityLog;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\TransactionDetail;
use App\Product;
use App\MaterialData;
use Gate;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MaterialSalesReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        abort_if(Gate::denies('material_sales_report_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $tanggal_mulai = $request->input('tanggal_mulai');
        $tanggal_akhir = $request->input('tanggal_akhir');

        $query = MaterialData::leftJoin('product_details', 'material_data.id', '=', 'product_details.material_id')
            ->leftJoin('transaction_details', function ($join) use ($tanggal_mulai, $tanggal_akhir) {
                $join->on('product_details.product_id', '=', 'transaction_details.product_id')
                    ->whereBetween('transaction_details.created_at', [$tanggal_mulai, $tanggal_akhir])
                    ->orWhereNull('transaction_details.created_at');
            })
            ->select('material_data.*', DB::raw('SUM(product_details.dose) as total_dose'))
            ->groupBy('material_data.id');

        // Conditional orderBy clauses
        $materialSales = $query->orderByDesc('total_dose')
            ->orderBy('material_data.name', 'asc')
            ->get();



        // dd($query);

        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'action' => 'Mengakses menu laporan penjualan material',
            'details' => 'Mengakses menu laporan penjualan material'
        ]);

        return view('finance.material-sales-report.index', compact('materialSales', 'tanggal_mulai', 'tanggal_akhir'));
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
