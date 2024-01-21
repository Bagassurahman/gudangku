<?php

namespace App\Http\Controllers\Warehouse;

use App\ActivityLog;
use App\Account;
use App\Balance;
use App\Deposit;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert as SweetAlert;

class DepositController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $depositsQuery = Deposit::where('warehouse_id', Auth::user()->id);

        if ($request->filled('tanggal_mulai') && $request->filled('tanggal_akhir')) {
            $tanggalMulai = Carbon::parse($request->input('tanggal_mulai'))->startOfDay();
            $tanggalAkhir = Carbon::parse($request->input('tanggal_akhir'))->endOfDay();

            $depositsQuery->whereBetween('created_at', [$tanggalMulai, $tanggalAkhir]);
        }

        $deposits = $depositsQuery->get();

        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'action' => 'Mengakses menu setoran',
            'details' => 'Mengakses menu setoran'
        ]);

        return view('warehouse.deposit.index', compact('deposits'));
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
    public function update(Request $request, $id)
    {
        $account_number_outlet = Account::where('account_number', $request->account_number)->first();
        $account_number_warehouse = Account::where('user_id', Auth::user()->id)->first();

        $deposit = Deposit::find($id);

        // Add balance to warehouse
        Balance::addBalance($account_number_warehouse->id, $deposit->amount);

        // Reduce balance from outlet
        Balance::reduceBalance($account_number_outlet->id, $deposit->amount);


        $deposit->update([
            'status' => 'success'
        ]);

        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'action' => 'Mengubah status setoran',
            'details' => 'Mengubah status setoran'
        ]);

        SweetAlert::success('Berhasil', 'Setoran berhasil di konfirmasi');

        return redirect()->route('warehouse.setoran.index');
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
