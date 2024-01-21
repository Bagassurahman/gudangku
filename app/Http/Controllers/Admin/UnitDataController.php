<?php

namespace App\Http\Controllers\Admin;

use App\ActivityLog;
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

        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'action' => 'Mengakses menu data satuan',
            'details' => 'Mengakses menu data satuan'
        ]);

        return view('admin.units-data.index', compact('units'));
    }


    public function create()
    {
        abort_if(Gate::denies('unit_data_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'action' => 'Mengakses menu tambah data satuan',
            'details' => 'Mengakses menu tambah data satuan'
        ]);

        return view('admin.units-data.create');
    }

    public function store(StoreUnitDataRequest $request)
    {

        $unit = UnitData::create($request->all());

        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'action' => 'Menambahkan data satuan baru',
            'details' => 'Menambahkan data satuan baru dengan nama ' . $unit->name
        ]);

        SweetAlert::toast('Data satuan berhasil ditambahkan', 'success')->timerProgressBar();

        return redirect()->route('admin.data-satuan.index');
    }


    public function show($id)
    {
        abort_if(Gate::denies('unit_data_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $unit = UnitData::findOrFail($id);


        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'action' => 'Mengakses detail data satuan',
            'details' => 'Mengakses detail data satuan dengan nama ' . $unit->name
        ]);

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

        // log
        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'action' => 'Menghapus data satuan',
            'details' => 'Menghapus data satuan dengan nama ' . $unit->name
        ]);

        SweetAlert::toast('Data satuan berhasil dihapus', 'success')->timerProgressBar();

        return back();
    }
}
