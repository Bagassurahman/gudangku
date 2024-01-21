<?php

namespace App\Http\Controllers\Finance;

use App\ActivityLog;
use App\Distribution;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DistributionReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Distribution::join('distribution_details', 'distributions.id', '=', 'distribution_details.distribution_id')
            ->select(DB::raw('distributions.distribution_date, SUM(distribution_details.total) as total'))
            ->groupBy('distributions.distribution_date')
            ->orderBy('distributions.distribution_date', 'desc');


        if ($request->filled('tanggal_mulai') && $request->filled('tanggal_akhir')) {
            $tanggalMulai = $request->input('tanggal_mulai');
            $tanggalAkhir = $request->input('tanggal_akhir');

            $query->whereDate('distributions.distribution_date', '>=', $tanggalMulai)
                ->whereDate('distributions.distribution_date', '<=', $tanggalAkhir);
        } elseif ($request->filled('tanggal_mulai')) {
            $tanggalMulai = $request->input('tanggal_mulai');

            $query->whereDate('distributions.distribution_date', '>=', $tanggalMulai);
        }

        $distributions = $query->get();

        foreach ($distributions as $distribution) {
            $date = Carbon::parse($distribution->distribution_date)->format('d F Y');
            $distribution->distribution_date = $date;
        }

        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'action' => 'Mengakses menu laporan distribusi',
            'details' => 'Mengakses menu laporan distribusi'
        ]);

        return view('finance.distribution-report.index', compact('distributions'));
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
            ->join('users', 'distributions.warehouse_id', '=', 'users.id')
            ->select('distributions.warehouse_id', 'users.warehouse_name', 'distributions.distribution_date', DB::raw('SUM(distribution_details.total) as total_sales'))
            ->where('distributions.distribution_date', $newDate)
            ->groupBy('users.id', 'users.warehouse_name', 'distributions.distribution_date')
            ->get();

        // log
        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'action' => 'Mengakses menu laporan distribusi',
            'details' => 'Mengakses menu laporan distribusi'
        ]);


        return view('finance.distribution-report.show', [
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

    public function showDetail($date, $warehouseId)
    {
        $newDate = date('Y-m-d', strtotime($date));

        $distributionDetails = Distribution::join('outlets', 'distributions.outlet_id', '=', 'outlets.user_id')
            ->join('distribution_details', 'distributions.id', '=', 'distribution_details.distribution_id')
            ->select('distributions.outlet_id', 'outlets.outlet_name', DB::raw('SUM(distribution_details.quantity) as total_distribution'))
            ->where('distributions.distribution_date', $newDate)
            ->where('distributions.warehouse_id', $warehouseId)
            ->groupBy('distributions.outlet_id', 'outlets.outlet_name')
            ->get();


        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'action' => 'Mengakses menu laporan distribusi',
            'details' => 'Mengakses menu laporan distribusi'
        ]);


        return view('finance.distribution-report.detail', [
            'distributionDetails' => $distributionDetails,
            'date' => $date,
            'warehouse' => DB::table('users')
                ->select('warehouse_name')
                ->where('id', $warehouseId)
                ->first(),
            'warehouse_id' => $warehouseId
        ]);
    }

    public function showMaterial($date, $outletId)
    {
        $newDate = date('Y-m-d', strtotime($date));
        $distributionDetails = Distribution::join('distribution_details', 'distributions.id', '=', 'distribution_details.distribution_id')
            ->join('material_data', 'distribution_details.material_id', '=', 'material_data.id')
            ->join('users', 'distributions.outlet_id', '=', 'users.id')
            ->select('users.warehouse_name', 'material_data.name as material_name', 'material_data.selling_price', DB::raw('SUM(distribution_details.quantity) as total_quantity'), DB::raw('SUM(distribution_details.quantity * material_data.selling_price) as total_price'))
            ->where('distributions.distribution_date', $newDate)
            ->where('distributions.outlet_id', $outletId)
            ->groupBy('users.warehouse_name', 'material_data.name', 'material_data.selling_price')
            ->get();


        // log
        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'action' => 'Mengakses menu laporan distribusi',
            'details' => 'Mengakses menu laporan distribusi'
        ]);



        return view('finance.distribution-report.show-material', [
            'distributionDetails' => $distributionDetails,
            'date' => $date,
            'outlet' => DB::table('outlets')
                ->select('outlet_name')
                ->where('user_id', $outletId)
                ->first(),
        ]);
    }
}
