<?php

namespace App\Http\Controllers\Warehouse;

use App\ActivityLog;
use App\Distribution;
use App\Inventory;
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
            ->select(DB::raw('MONTH(distributions.distribution_date) as month, SUM(distribution_details.total) as total'))
            ->where('distributions.warehouse_id', Auth::user()->id)
            ->groupBy('month')
            ->orderBy('month', 'desc')
            ->get();

        foreach ($distributions as $distribution) {
            $date = Carbon::create(null, $distribution->month)->format('F Y');
            $distribution->distribution_date = $date;
        }

        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'action' => 'Mengakses menu Laporan Distribusi',
            'details' => 'Mengakses menu Laporan Distribusi'
        ]);

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
            ->select('material_data.id as material_id', 'distributions.distribution_date', 'material_data.name as material_name', 'material_data.last_price', DB::raw('SUM(distribution_details.quantity) as total_quantity'), DB::raw('SUM(distribution_details.total) as total_sales'), 'material_data.selling_price')
            ->where('distributions.distribution_date', $newDate)
            ->groupBy('material_data.id', 'distributions.distribution_date', 'material_data.name', 'material_data.selling_price', 'material_data.last_price')
            ->get();
            
        $materialIds = $distributionDetails->pluck('material_id')->toArray();
        $inventory = Inventory::whereIn('material_data_id', $materialIds)->get();
        // dd($materialIds);


        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'action' => 'Mengakses menu Laporan Distribusi by Tanggal',
            'details' => 'Mengakses menu Laporan Distribusi by Tanggal'
        ]);


        return view('warehouse.distribution-report.show', [
            'distributionDetails' => $distributionDetails,
            'date' => $date,
            'inventory' => $inventory
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

    public function showDate($month)
    {
        // Mendapatkan tahun saat ini
        $currentYear = date('Y');

        // Mengubah bulan menjadi format dua digit (misalnya 01 untuk Januari)
        $formattedMonth = str_pad($month, 2, '0', STR_PAD_LEFT);

        // Membuat tanggal awal dan akhir berdasarkan bulan dan tahun saat ini
        $startDate = "{$currentYear}-{$formattedMonth}-01";
        $endDate = "{$currentYear}-{$formattedMonth}-31"; // Anda juga dapat menggunakan tanggal akhir bulan yang valid

        $distributions = Distribution::join('distribution_details', 'distributions.id', '=', 'distribution_details.distribution_id')
            ->select(DB::raw('distributions.distribution_date, SUM(distribution_details.total) as total'))
            ->where('distributions.warehouse_id', Auth::user()->id)
            ->whereBetween('distributions.distribution_date', [$startDate, $endDate])
            ->groupBy('distributions.distribution_date')
            ->orderBy('distributions.distribution_date', 'desc')
            ->get();

        foreach ($distributions as $distribution) {
            $date = Carbon::parse($distribution->distribution_date)->format('d F Y');
            $distribution->distribution_date = $date;
        }

        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'action' => 'Mengakses menu Laporan D',
            'details' => 'Mengakses menu Laporan D'
        ]);


        return view('warehouse.distribution-report.show-date', [
            'distributions' => $distributions
        ]);
    }
}
