<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreWarehouseManagementRequest;
use App\User;
use Illuminate\Http\Request;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class WarehouseManagementController extends Controller
{

    public function index()
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $warehouse = User::with('roles')->whereHas('roles', function ($q) {
            $q->where('title', 'Gudang');
        })->get();

        return view('admin.warehouse-management.index', compact('warehouse'));
    }


    public function create()
    {
        abort_if(Gate::denies('user_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.warehouse-management.create');
    }

    public function store(StoreWarehouseManagementRequest $request)
    {
        $user = User::create($request->all());
        $user->roles()->sync('2');

        return redirect()->route('admin.manajemen-gudang.index');
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
