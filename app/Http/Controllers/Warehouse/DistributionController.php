<?php

namespace App\Http\Controllers\Warehouse;

use App\ActivityLog;
use App\Debt;
use App\Distribution;
use App\DistributionDetail;
use App\Http\Controllers\Controller;
use App\Inventory;
use App\MaterialData;
use App\Outlet;
use Illuminate\Http\Request;
use Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use RealRashid\SweetAlert\Facades\Alert as SweetAlert;

class DistributionController extends Controller
{

    public function index()
    {
        abort_if(Gate::denies('distribution_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $distributions = Distribution::join('distribution_details', 'distributions.id', '=', 'distribution_details.distribution_id')
            ->join('outlets', 'distributions.outlet_id', '=', 'outlets.user_id')
            ->select(DB::raw('outlets.outlet_name , SUM(distribution_details.total) as total, SUM(distributions.fee) as total_fee, distributions.outlet_id'))
            ->where('distributions.warehouse_id', Auth::user()->id)
            ->groupBy('distributions.outlet_id', 'outlets.outlet_name')
            ->orderBy('distributions.outlet_id')
            ->get();

        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'action' => 'Mengakses menu distribusi di Gudang',
            'details' => 'Mengakses menu distribusi di Gudang'
        ]);


        return view('warehouse.distribution.index', compact('distributions'));
    }


    public function create()
    {
        abort_if(Gate::denies('distribution_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $outlets = Outlet::where('warehouse_id', Auth::user()->id)->get();
        $materials = Inventory::where('warehouse_id', Auth::user()->id)->get()->sortBy('material_data.material_name');

        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'action' => 'Mengakses menu Tambah Distribusi di Gudang',
            'details' => 'Mengakses menu Tambah Distribusi di Gudang'
        ]);

        return view('warehouse.distribution.create', compact('outlets', 'materials'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cartItems = json_decode($request->input('cart_items'), true);

        $distribution = Distribution::create([
            'warehouse_id' => Auth::user()->id,
            'distribution_number' => 'DIS' . date('Ymd') . sprintf('%06d', mt_rand(1, 999999)),
            'outlet_id' => $request->outlet_id,
            'distribution_date' => $request->po_date,
            'fee' => '0',
            'status' => 'on_progres'
        ]);


        foreach ($cartItems as $cartItem) {
            DistributionDetail::create([
                'distribution_id' => $distribution->id,
                'material_id' => $cartItem['id'],
                'quantity' => $cartItem['count'],
                'total' => $cartItem['total']
            ]);
        }

        $total_akhir = 0;

        foreach ($cartItems as $cartItem) {
            $total_akhir += $cartItem['total'];
        }

        Debt::create([
            'outlet_id' => $request->outlet_id,
            'warehouse_id' => Auth::user()->id,
            'date' => $request->po_date,
            'amount' => $total_akhir,
            'status' => 'pending'
        ]);

        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'action' => 'Menambah data Distribusi dan tambah data Hutang Piutang',
            'details' => 'Menambah data Distribusi dan tambah data Hutang Piutang'
        ]);

        SweetAlert::success('Berhasil', 'Distribusi berhasil');


        return redirect()->route('warehouse.distribusi.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($outlet_id)
    {
        $distributionDetails = Distribution::join('distribution_details', 'distributions.id', '=', 'distribution_details.distribution_id')
            ->join('outlets', 'distributions.outlet_id', '=', 'outlets.user_id')
            ->select('distributions.id', 'distributions.distribution_date', 'distributions.fee', DB::raw('SUM(distribution_details.total) AS total_summary'), 'distributions.status')
            ->where('outlets.user_id', $outlet_id)
            ->orderBy('distributions.distribution_date', 'desc')
            ->orderBy('distributions.id', 'desc')
            ->groupBy('distributions.id')
            ->get();




        $outlet = Outlet::find($outlet_id);


        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'action' => 'Mengakses menu detail Distribusi by outlet',
            'details' => 'Mengakses menu detail Distribusi by outlet'
        ]);

        return view('warehouse.distribution.show', compact('distributionDetails', 'outlet'));
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
        $distribution = Distribution::findOrFail($id);
        $detail = DistributionDetail::where('distribution_id', $id)->first();

        $distribution->delete();
        $detail->delete();

        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'action' => 'Menghapus data Distribusi',
            'details' => 'Menghapus data Distribusi'
        ]);

        SweetAlert::success('Berhasil', 'Distribusi berhasil dihapus');

        return redirect()->route('warehouse.distribusi.index');
    }


    public function detail($id)
    {
        $distribution = Distribution::findOrFail($id);
        $details = DistributionDetail::with('material')->where('distribution_id', $id)->get();

        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'action' => 'Mengakses menu Detail distribusi by id',
            'details' => 'Mengakses menu Detail distribusi by id'
        ]);

        //     $distributionDetails = Distribution::join('distribution_details', 'distributions.id', '=', 'distribution_details.distribution_id')
        // ->select('distributions.id', 'distributions.distribution_date', 'distributions.fee', 'distribution_details.total', 'distributions.status')
        // ->where('distribution_details.distribution_id', $id)
        // ->get();

        return view('warehouse.distribution.detail', compact('distribution', 'details'));
    }

    public function checkStock(Request $request)
    {
        $inventory = DB::table('inventories')
            ->where('material_data_id', '=', $request->input('material_id'))
            ->where('warehouse_id', '=', Auth::user()->id)
            ->select('remaining_amount')
            ->first();

        return response()->json($inventory->remaining_amount);
    }

    public function reduceStock(Request $request)
    {
        $inventory = Inventory::where('warehouse_id', Auth::user()->id)->where('material_data_id', $request->material_id)->first();

        $inventory->update([
            'remaining_amount' => $inventory->remaining_amount - 1
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Stok berhasil dikurangi'
        ]);
    }

    public function increaseStock(Request $request)
    {
        $inventory = Inventory::where('warehouse_id', Auth::user()->id)->where('material_data_id', $request->material_id)->first();

        $inventory->update([
            'remaining_amount' => $inventory->remaining_amount + 1
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Stok berhasil ditambah'
        ]);
    }
}
