<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOutletRequest;
use App\Outlet;
use App\User;
use Illuminate\Http\Request;
use Gate;
use Symfony\Component\HttpFoundation\Response;
use RealRashid\SweetAlert\Facades\Alert as SweetAlert;

class OutletManagementController extends Controller
{

    public function index()
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $outlets = User::with('roles')->whereHas('roles', function ($q) {
            $q->where('title', 'Outlet');
        })->get();

        return view('admin.outlet-management.index', compact('outlets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(Gate::denies('user_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $warehouse = User::with('roles')->whereHas('roles', function ($q) {
            $q->where('title', 'Gudang');
        })->get();

        return view('admin.outlet-management.create', compact('warehouse'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOutletRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'phone' => $request->phone_number,
            'address' => $request->address,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        $user->roles()->attach(3);

        Outlet::create([
            'outlet_name' => $request->outlet_name,
            'target' => $request->target,
            'warehouse_id' => $request->warehouse_id,
            'user_id' => $user->id
        ]);

        SweetAlert::toast('Outlet berhasil ditambahkan', 'success');

        return redirect()->route('admin.manajemen-outlet.index');
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
