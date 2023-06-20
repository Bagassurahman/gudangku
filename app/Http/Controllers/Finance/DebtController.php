<?php

namespace App\Http\Controllers\Finance;

use App\Debt;
use App\Http\Controllers\Controller;
use App\Riche;
use Carbon\Carbon;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert as SweetAlert;

class DebtController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $debts = Debt::with(['outlet', 'warehouse'])->get();

        return view('finance.debt.index', compact('debts'));
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
        $parsedDate = Carbon::parse($debt->date);
        $riche = Riche::where('date', $parsedDate->format('Y-m'))
            ->where('outlet_id', $debt->outlet_id)
            ->first();

        if ($riche->total < $debt->amount) {
            SweetAlert::error('Gagal', 'Kekayaan Outlet Tidak Cukup');
        } else {
            $debt->update([
                'status' => 'on_progres'
            ]);

            $riche->update([
                'debit' => $riche->debit + $debt->amount,
                'sub_total' => $riche->sub_total - $debt->amount
            ]);

            SweetAlert::success('Berhasil', 'Hutang Berhasil Dilunasi');
        }



        return redirect()->back();
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
