<?php

namespace App\Http\Controllers\Warehouse;

use App\ActivityLog;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSupplierRequest;
use App\Supplier;
use Illuminate\Http\Request;
use Gate;
use Symfony\Component\HttpFoundation\Response;
use RealRashid\SweetAlert\Facades\Alert as SweetAlert;

class SupplierController extends Controller
{

    public function index()
    {
        abort_if(Gate::denies('supplier_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $suppliers = Supplier::all();

        return view('warehouse.suppliers.index', compact('suppliers'));
    }


    public function create()
    {
        abort_if(Gate::denies('supplier_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('warehouse.suppliers.create');
    }


    public function store(StoreSupplierRequest $request)
    {
        $supplier = Supplier::create($request->all());

        SweetAlert::toast('Suplier berhasil ditambahkan', 'success');

        return redirect()->route('warehouse.suppliers.index');
    }


    public function show($id)
    {
        abort_if(Gate::denies('supplier_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $supplier = Supplier::find($id);

        return view('warehouse.suppliers.show', compact('supplier'));
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
        abort_if(Gate::denies('supplier_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $supplier = Supplier::findOrFail($id);

        $supplier->delete();

        SweetAlert::toast('Data Supplier berhasil dihapus', 'success')->timerProgressBar();

        return back();
    }
}
