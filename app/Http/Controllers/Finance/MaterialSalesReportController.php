<?php

namespace App\Http\Controllers\Finance;

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

        $filter = $request->input('filter', 'all');

        $query = MaterialData::leftJoin('product_details', 'material_data.id', '=', 'product_details.material_id')
            ->leftJoin('transaction_details', function ($join) {
                $join->on('product_details.product_id', '=', 'transaction_details.product_id')
                    ->where('transaction_details.qty', '!=', 0);
            })
            ->select('material_data.*', DB::raw('SUM(product_details.dose) as total_dose'))
            ->groupBy('material_data.id')
            ->orderByDesc('total_dose');


        if ($filter == 'daily') {
            $query->where(function ($query) {
                $query->whereDate('transaction_details.created_at', '=', Carbon::today()->toDateString())
                    ->orWhereNull('transaction_details.created_at');
            });
        } elseif ($filter == 'monthly') {
            $query->where(function ($query) {
                $query->whereYear('transaction_details.created_at', '=', Carbon::today()->year)
                    ->whereMonth('transaction_details.created_at', '=', Carbon::today()->month)
                    ->orWhereNull('transaction_details.created_at');
            });
        } elseif ($filter == 'yearly') {
            $query->where(function ($query) {
                $query->whereYear('transaction_details.created_at', '=', Carbon::today()->year)
                    ->orWhereNull('transaction_details.created_at');
            });
        }

        $materialSales = $query->get();


        // dd($query);

        return view('finance.material-sales-report.index', compact('materialSales'));
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
