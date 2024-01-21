<?php

namespace App\Http\Controllers\Warehouse;

use App\ActivityLog;
use App\Debt;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert as SweetAlert;
use Illuminate\Support\Facades\DB;

class DebtController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $debts = Debt::with(['outlet', 'warehouse'])
            ->where('warehouse_id', Auth::user()->id)

            ->orderBy('status', 'desc')
            ->orderBy('date', 'desc')
            ->get();

        $wait = DB::table('debts')
            ->where('status', 'on_progres')
            ->sum('amount');

        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'action' => 'Mengakses menu Hutang Piutang',
            'details' => 'Mengakses menu Hutang Piutang'
        ]);

        return view('warehouse.debt.index', compact('debts', 'wait'));
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
        $debt = Debt::findOrFail($id);

        $debt->update([
            'status' => $request->status
        ]);

        if ($request->status == 'pending') {
            SweetAlert::success('Berhasil', 'Request pelunasan berhasil');
        }

        if ($request->status == 'success') {
            SweetAlert::success('Berhasil', 'Pelunasan berhasil');
        }

        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'action' => 'Mengubah data Status Hutang Piutang',
            'details' => 'Mengubah data Status Hutang Piutang'
        ]);

        return redirect()->route('warehouse.hutang-piutang.index');
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
