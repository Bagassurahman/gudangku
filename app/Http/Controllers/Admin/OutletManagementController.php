<?php

namespace App\Http\Controllers\Admin;

use App\Account;
use App\ActivityLog;
use App\Balance;
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

        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'action' => 'Mengakses menu manajemen outlet',
            'details' => 'Mengakses menu manajemen outlet'
        ]);

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

        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'action' => 'Mengakses menu tambah outlet',
            'details' => 'Mengakses menu tambah outlet'
        ]);

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

        $roleId = $user->roles[0]->id;
        $phoneLastTwoDigits = substr($user->phone_number, -2);
        $userIdDigits = str_pad($user->id, 4, '0', STR_PAD_LEFT);

        $accountNumber = $roleId . rand(10, 99) . $phoneLastTwoDigits . $userIdDigits;

        $account = Account::create([
            'user_id' => $user->id,
            'account_number' => $accountNumber,
        ]);

        Balance::create([
            'account_id' => $account->id,
            'balance' => rand(100, 10000),
        ]);

        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'action' => 'Menambahkan outlet baru',
            'details' => 'Menambahkan outlet baru dengan nama ' . $user->name
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

        $outlet = User::with('roles')->whereHas('roles', function ($q) {
            $q->where('title', 'Outlet');
        })->findOrFail($id);

        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'action' => 'Mengakses detail outlet',
            'details' => 'Mengakses detail outlet dengan nama ' . $outlet->name
        ]);

        return view('admin.outlet-management.show', compact('outlet'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $outlet = User::with('roles')->whereHas('roles', function ($q) {
            $q->where('title', 'Outlet');
        })->findOrFail($id);

        $warehouse = User::with('roles')->whereHas('roles', function ($q) {
            $q->where('title', 'Gudang');
        })->get();

        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'action' => 'Mengakses menu edit outlet',
            'details' => 'Mengakses menu edit outlet dengan nama ' . $outlet->name
        ]);

        return view('admin.outlet-management.edit', compact('outlet', 'warehouse'));
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
        if ($request->password) {
            $user = User::findOrFail($id);
            $user->update([
                'name' => $request->name,
                'phone' => $request->phone,
                'address' => $request->address,
                'email' => $request->email,
                'password' => bcrypt($request->password)
            ]);

            $outlet = Outlet::where('user_id', $id)->first();

            $outlet->update([
                'outlet_name' => $request->outlet_name,
                'target' => $request->target,
                'warehouse_id' => $request->warehouse_id,
            ]);
        } else {
            $user = User::findOrFail($id);
            $user->update([
                'name' => $request->name,
                'phone' => $request->phone,
                'address' => $request->address,
                'email' => $request->email,
            ]);


            $outlet = Outlet::where('user_id', $id)->first();

            $outlet->update([
                'outlet_name' => $request->outlet_name,
                'target' => $request->target,
                'warehouse_id' => $request->warehouse_id,
            ]);
        }

        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'action' => 'Mengubah data outlet',
            'details' => 'Mengubah data outlet dengan nama ' . $user->name
        ]);

        SweetAlert::toast('Outlet berhasil diupdate', 'success');

        return redirect()->route('admin.manajemen-outlet.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'action' => 'Menghapus data outlet',
            'details' => 'Menghapus data outlet dengan nama ' . $user->name
        ]);

        SweetAlert::toast('Data berhasil dihapus', 'success');

        return redirect()->route('admin.manajemen-outlet.index');
    }
}
