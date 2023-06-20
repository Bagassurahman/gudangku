<?php

namespace App\Http\Controllers\Warehouse;

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




        return view('warehouse.inventory.index', compact('inventories'));
    }


    public function create()
    {
        abort_if(Gate::denies('inventory_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $materials = MaterialData::all();

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
