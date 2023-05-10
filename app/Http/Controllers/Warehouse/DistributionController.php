<?php

namespace App\Http\Controllers\Warehouse;

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


        return view('warehouse.distribution.index', compact('distributions'));
    }


    public function create()
    {
        abort_if(Gate::denies('distribution_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $outlets = Outlet::where('warehouse_id', Auth::user()->id)->get();
        $materials = Inventory::where('warehouse_id', Auth::user()->id)->get();


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
            'status' => 'accepted'
        ]);


        foreach ($cartItems as $cartItem) {
            $inventory = Inventory::where('warehouse_id', Auth::user()->id)->where('material_data_id', $cartItem['id'])->first();
            $inventory->update([
                'exit_amount' => $inventory->exit_amount + $cartItem['count'],
                'remaining_amount' => $inventory->remaining_amount - $cartItem['count']
            ]);

            DistributionDetail::create([
                'distribution_id' => $distribution->id,
                'material_id' => $cartItem['id'],
                'quantity' => $cartItem['count'],
                'total' => $cartItem['total']
            ]);

            // update in outlet
            $inventoryOutlet = Inventory::where('outlet_id', $request->outlet_id)->where('material_data_id', $cartItem['id'])->first();
            if ($inventoryOutlet) {
                $inventoryOutlet->update([
                    'entry_amount' => $inventoryOutlet->entry_amount + $cartItem['count'],
                    'remaining_amount' => $inventoryOutlet->remaining_amount + $cartItem['count']
                ]);
            } else {
                Inventory::create([
                    'outlet_id' => $request->outlet_id,
                    'material_data_id' => $cartItem['id'],
                    'entry_amount' => $cartItem['count'],
                    'remaining_amount' => $cartItem['count']
                ]);
            }
        }

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
            ->select('distributions.distribution_date', 'distributions.fee', 'distribution_details.total', 'distributions.status')
            ->where('distributions.outlet_id', $outlet_id)
            ->get();

        $outlet = Outlet::find($outlet_id);

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
        //
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
}
