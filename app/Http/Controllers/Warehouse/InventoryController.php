<?php

namespace App\Http\Controllers\Warehouse;

use App\ActivityLog;
use App\Distribution;
use App\DistributionDetail;
use App\Http\Controllers\Controller;
use App\MaterialData;
use Illuminate\Http\Request;
use Gate;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class InventoryController extends Controller
{

    public function index()
    {
        abort_if(Gate::denies('inventory_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $userId = Auth::id();


        $inventories = MaterialData::with(['inventories' => function ($query) use ($userId) {
            $query->where('warehouse_id', $userId);
        }, 'inventories.material.unit'])->get();


        $distributionDetails = DistributionDetail::whereHas('distribution', function ($query) {
            $query->where('status', 'on_progres');
        })->get();



        $combinedData = [];

        foreach ($inventories as $inventory) {
            $totalQuantity = $distributionDetails->where('material_id', $inventory->id)->sum('quantity');
            $combinedData[] = [
                'inventory' => $inventory,
                'totalQuantity' => $totalQuantity,
            ];
        }

        // log
        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'action' => 'Mengakses menu Inventory',
            'details' => 'Mengakses menu Inventory'
        ]);




        return view('warehouse.inventory.index', compact('combinedData'));
    }


    public function create()
    {
        abort_if(Gate::denies('inventory_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $materials = MaterialData::all();

        // log
        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'action' => 'Mengakses menu Tambah Inventory',
            'details' => 'Mengakses menu Tambah Inventory'
        ]);

        return view('warehouse.inventory.create', compact('materials'));
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
