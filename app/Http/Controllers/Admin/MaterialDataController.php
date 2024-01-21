<?php

namespace App\Http\Controllers\Admin;

use App\ActivityLog;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMaterialDataRequest;
use App\Http\Requests\UpdateMaterialDataRequest;
use App\MaterialData;
use App\UnitData;
use Illuminate\Http\Request;
use Gate;
use Symfony\Component\HttpFoundation\Response;
use RealRashid\SweetAlert\Facades\Alert as SweetAlert;


class MaterialDataController extends Controller
{

    public function index()
    {
        abort_if(Gate::denies('material_data_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $materials = MaterialData::all();

        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'action' => 'Mengakses menu data bahan',
            'details' => 'Mengakses menu data bahan'
        ]);

        return view('admin.materials-data.index', compact('materials'));
    }

    public function create()
    {
        abort_if(Gate::denies('material_data_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $units = UnitData::all();

        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'action' => 'Mengakses menu tambah data bahan',
            'details' => 'Mengakses menu tambah data bahan'
        ]);

        return view('admin.materials-data.create', compact('units'));
    }


    public function store(StoreMaterialDataRequest $request)
    {
        $material = MaterialData::create($request->all());

        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'action' => 'Menambahkan data bahan baru',
            'details' => 'Menambahkan data bahan baru dengan nama ' . $material->name
        ]);

        SweetAlert::toast('Data bahan berhasil ditambahkan', 'success')->timerProgressBar();

        return redirect()->route('admin.data-bahan.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort_if(Gate::denies('material_data_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $material = MaterialData::findOrFail($id);

        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'action' => 'Mengakses detail data bahan',
            'details' => 'Mengakses detail data bahan dengan nama ' . $material->name
        ]);

        return view('admin.materials-data.show', compact('material'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_if(Gate::denies('material_data_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $units = UnitData::all();
        $material = MaterialData::findOrFail($id);

        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'action' => 'Mengakses menu ubah data bahan',
            'details' => 'Mengakses menu ubah data bahan dengan nama ' . $material->name
        ]);

        return view('admin.materials-data.edit', compact('units', 'material'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMaterialDataRequest $request, $id)
    {
        $material = MaterialData::findOrFail($id);

        $material->update($request->all());

        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'action' => 'Mengubah data bahan',
            'details' => 'Mengubah data bahan dengan nama ' . $material->name
        ]);

        SweetAlert::toast('Data bahan berhasil diubah', 'success')->timerProgressBar();

        return redirect()->route('admin.data-bahan.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_if(Gate::denies('material_data_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $material = MaterialData::findOrFail($id);

        $material->delete();

        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'action' => 'Menghapus data bahan',
            'details' => 'Menghapus data bahan dengan nama ' . $material->name
        ]);

        SweetAlert::toast('Data satuan berhasil dihapus', 'success')->timerProgressBar();

        return back();
    }
}
