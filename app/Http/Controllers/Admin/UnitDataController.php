<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUnitDataRequest;
use App\UnitData;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Gate;
use RealRashid\SweetAlert\Facades\Alert as SweetAlert;

class UnitDataController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('unit_data_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $units = UnitData::all();

        return view('admin.units-data.index', compact('units'));
    }


    public function create()
    {
        abort_if(Gate::denies('unit_data_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.units-data.create');
    }

    public function store(StoreUnitDataRequest $request)
    {

        $unit = UnitData::create($request->all());

        SweetAlert::toast('Data satuan berhasil ditambahkan', 'success')->timerProgressBar();

        return redirect()->route('admin.data-satuan.index');
    }


    public function show($id)
    {
        abort_if(Gate::denies('unit_data_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $unit = UnitData::findOrFail($id);

        return view('admin.units-data.show', compact('unit'));
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        abort_if(Gate::denies('unit_data_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $unit = UnitData::findOrFail($id);

        $unit->delete();

        SweetAlert::toast('Data satuan berhasil dihapus', 'success')->timerProgressBar();

        return back();
    }
}
