<?php

namespace App\Http\Controllers\Warehouse;

use App\Distribution;
use App\Http\Controllers\Controller;
use App\Inventory;
use App\MaterialData;
use App\Outlet;
use Illuminate\Http\Request;
use Gate;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class DistributionController extends Controller
{

    public function index()
    {
        abort_if(Gate::denies('distribution_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $distributions = Distribution::where('warehouse_id', Auth::user()->id)->get();

        return view('warehouse.distribution.index', compact('distributions'));
    }


    public function create()
    {
        abort_if(Gate::denies('distribution_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $outlets = Outlet::where('warehouse_id', Auth::user()->id)->get();
        $materials = Inventory::where('remaining_amount', '>=', 0)->get();


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
