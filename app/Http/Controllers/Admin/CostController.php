<?php

namespace App\Http\Controllers\Admin;

use App\ActivityLog;
use App\Cost;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCostRequest;
use Illuminate\Http\Request;
use Gate;
use Symfony\Component\HttpFoundation\Response;
use RealRashid\SweetAlert\Facades\Alert as SweetAlert;


class CostController extends Controller
{

    public function index()
    {
        abort_if(Gate::denies('cost_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $costs = Cost::all();

        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'action' => 'Mengakses menu biaya',
            'details' => 'Mengakses menu biaya'
        ]);

        return view('admin.costs.index', compact('costs'));
    }


    public function create()
    {
        abort_if(Gate::denies('cost_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'action' => 'Mengakses menu tambah biaya',
            'details' => 'Mengakses menu tambah biaya'
        ]);

        return view('admin.costs.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCostRequest $request)
    {
        $cost = Cost::create($request->all());

        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'action' => 'Menambahkan biaya baru',
            'details' => 'Menambahkan biaya baru dengan nama ' . $cost->name
        ]);

        SweetAlert::toast('Data biaya berhasil ditambahkan', 'success');

        return redirect()->route('admin.biaya.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_if(Gate::denies('cost_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $cost = Cost::findOrFail($id);

        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'action' => 'Mengakses menu ubah biaya',
            'details' => 'Mengakses menu ubah biaya dengan nama ' . $cost->name
        ]);

        return view('admin.costs.edit', compact('cost'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\
     * Http\Response
     */
    public function update(StoreCostRequest $request, $id)
    {
        $cost = Cost::findOrFail($id);

        $cost->update($request->all());

        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'action' => 'Mengubah biaya',
            'details' => 'Mengubah biaya dengan nama ' . $cost->name
        ]);

        SweetAlert::toast('Data biaya berhasil diubah', 'success');

        return redirect()->route('admin.biaya.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cost = Cost::findOrFail($id);

        $cost->delete();

        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'action' => 'Menghapus biaya',
            'details' => 'Menghapus biaya dengan nama ' . $cost->name
        ]);

        SweetAlert::toast('Data biaya berhasil dihapus', 'success');

        return redirect()->route('admin.biaya.index');
    }
}
