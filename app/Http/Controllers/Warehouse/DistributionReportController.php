<?php

namespace App\Http\Controllers\Warehouse;

use App\Distribution;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DistributionReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $distributions = Distribution::join('distribution_details', 'distributions.id', '=', 'distribution_details.distribution_id')
            ->select(DB::raw('distributions.distribution_date, SUM(distribution_details.total) as total'))
            ->where('distributions.warehouse_id', Auth::user()->id)
            ->groupBy('distributions.distribution_date')
            ->orderBy('distributions.distribution_date')
            ->get();

        foreach ($distributions as $distribution) {
            $date = Carbon::parse($distribution->distribution_date)->format('d F Y');
            $distribution->distribution_date = $date;
        }

        return view('warehouse.distribution-report.index', [
            'distributions' => $distributions
        ]);
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
    public function show($date)
    {
        $newDate = date('Y-m-d', strtotime($date));

        $distributionDetails = Distribution::join('distribution_details', 'distributions.id', '=', 'distribution_details.distribution_id')
            ->join('material_data', 'distribution_details.material_id', '=', 'material_data.id')
            ->select('distributions.distribution_date', 'material_data.name as material_name', DB::raw('SUM(distribution_details.quantity) as total_quantity'), DB::raw('SUM(distribution_details.total) as total_sales'), 'material_data.selling_price')
            ->where('distributions.distribution_date', $newDate)
            ->groupBy('distributions.distribution_date', 'material_data.name', 'material_data.selling_price')
            ->get();


        return view('warehouse.distribution-report.show', [
            'distributionDetails' => $distributionDetails,
            'date' => $date
        ]);
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
