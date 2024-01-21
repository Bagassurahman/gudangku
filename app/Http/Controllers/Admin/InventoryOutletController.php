<?php

namespace App\Http\Controllers\Admin;

use App\ActivityLog;
use App\Http\Controllers\Controller;
use App\Inventory;
use App\Outlet;
use Illuminate\Http\Request;

class InventoryOutletController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $outlets = Outlet::all();

        return view('admin.inventory-outlet.index', compact('outlets'));
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
    public function update(Request $request)
    {
        $inventory = Inventory::findOrFail($request->inventory_id);

        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'action' => 'Update',
            'details' => 'Mengubah Stok Dari ' . $inventory->remaining_amount . ' menjadi ' . $request->remainingAmount
        ]);

        $inventory->update([
            'entry_amount' => $request->remainingAmount + $inventory->exit_amount,
            'remaining_amount' => $request->remainingAmount,
        ]);

        return response()->json([
            'message' => 'Data berhasil diupdate',
            'data' => $inventory
        ], 200);
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
