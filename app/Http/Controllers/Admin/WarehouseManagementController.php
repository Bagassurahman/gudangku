<?php

namespace App\Http\Controllers\Admin;

use App\Account;
use App\ActivityLog;
use App\Balance;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreWarehouseManagementRequest;
use App\User;
use Illuminate\Http\Request;
use Gate;
use Symfony\Component\HttpFoundation\Response;
use RealRashid\SweetAlert\Facades\Alert as SweetAlert;

class WarehouseManagementController extends Controller
{

    public function index()
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $warehouse = User::with('roles')->whereHas('roles', function ($q) {
            $q->where('title', 'Gudang');
        })->get();

        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'action' => 'Mengakses menu manajemen gudang',
            'details' => 'Mengakses menu manajemen gudang'
        ]);

        return view('admin.warehouse-management.index', compact('warehouse'));
    }


    public function create()
    {
        abort_if(Gate::denies('user_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'action' => 'Mengakses menu tambah gudang',
            'details' => 'Mengakses menu tambah gudang'
        ]);

        return view('admin.warehouse-management.create');
    }

    public function store(StoreWarehouseManagementRequest $request)
    {
        $user = User::create($request->all());
        $user->roles()->sync('2');

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
            'action' => 'Menambahkan gudang baru',
            'details' => 'Menambahkan gudang baru dengan nama ' . $user->name
        ]);

        SweetAlert::toast('Data berhasil ditambahkan', 'success');

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

        $warehouse = User::findOrFail($id);

        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'action' => 'Mengakses detail gudang',
            'details' => 'Mengakses detail gudang dengan nama ' . $warehouse->name
        ]);

        return view('admin.warehouse-management.show', compact('warehouse'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $warehouse = User::findOrFail($id);

        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'action' => 'Mengakses menu ubah gudang',
            'details' => 'Mengakses menu ubah gudang dengan nama ' . $warehouse->name
        ]);

        return view('admin.warehouse-management.edit', compact('warehouse'));
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
            $data = [
                'name' => $request->name,
                'warehouse_name' => $request->warehouse_name,
                'phone' => $request->phone,
                'address' => $request->address,
                'password' => bcrypt($request->password),
            ];
        } else {
            $data = [
                'name' => $request->name,
                'warehouse_name' => $request->warehouse_name,
                'phone' => $request->phone,
                'address' => $request->address,
            ];
        }

        User::where('id', $id)->update($data);

        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'action' => 'Mengubah data gudang',
            'details' => 'Mengubah data gudang dengan nama ' . $request->name
        ]);


        SweetAlert::toast('Data berhasil diubah', 'success');

        return redirect()->route('admin.manajemen-gudang.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $warehouse = User::findOrFail($id);
        $warehouse->delete();

        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'action' => 'Menghapus data gudang',
            'details' => 'Menghapus data gudang dengan nama ' . $warehouse->name
        ]);

        SweetAlert::toast('Data berhasil dihapus', 'success');

        return redirect()->route('admin.manajemen-gudang.index');
    }
}
