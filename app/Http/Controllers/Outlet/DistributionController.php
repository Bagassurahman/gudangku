<?php

namespace App\Http\Controllers\Outlet;

use App\Distribution;
use App\Http\Controllers\Controller;
use App\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DistributionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $distributions = Distribution::with('distributionDetails')
            ->where('outlet_id', Auth::user()->id)
            ->get();


        return view('outlet.distribution.index', compact('distributions'));
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
        $distribution = Distribution::with('distributionDetails.material')->findOrFail($id);

        return view('outlet.distribution.show', compact('distribution'));
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
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }

    public function accept($id)
    {
        $distribution = Distribution::with('distributionDetails')->findOrFail($id);

        foreach ($distribution->distributionDetails as $distributionDetail) {
            $inventory = Inventory::where('warehouse_id', $distribution->warehouse_id)->where('material_data_id', $distributionDetail->material_id)->first();
            $inventory->update([
                'exit_amount' => $inventory->exit_amount + $distributionDetail->quantity,
                'remaining_amount' => $inventory->remaining_amount - $distributionDetail->quantity

            ]);

            $inventoryOutlet = Inventory::where('outlet_id', Auth::user()->id)->where('material_data_id', $distributionDetail->material_id)->first();
            if ($inventoryOutlet) {
                $inventoryOutlet->update([
                    'entry_amount' => $inventoryOutlet->entry_amount + $distributionDetail->quantity,
                    'remaining_amount' => $inventoryOutlet->remaining_amount + $distributionDetail->quantity
                ]);
            } else {
                Inventory::create([
                    'outlet_id' => Auth::user()->id,
                    'material_data_id' => $distributionDetail->material_id,
                    'entry_amount' => $distributionDetail->quantity,
                    'remaining_amount' => $distributionDetail->quantity
                ]);
            }
        }


        $distribution->update([
            'status' => 'accepted'
        ]);
    }
}
