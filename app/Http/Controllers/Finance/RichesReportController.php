<?php

namespace App\Http\Controllers\Finance;

use App\Deposit;
use App\Http\Controllers\Controller;
use App\Outlet;
use App\Riche;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RichesReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $riches = Riche::with('outlet')->get();

        return view('finance.wealth-report.index', compact('riches'));
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
    public function show($date, $id)
    {
        $parsedDate = Carbon::createFromFormat('Y-m', $date);


        $riches = Deposit::whereRaw('DATE_FORMAT(deposit_date, "%Y-%m") = ?', $parsedDate->format('Y-m'))
            ->where('outlet_id', $id)
            ->get();

        $outlet = Outlet::where('user_id', $id)->first();

        return view('finance.wealth-report.show', compact('riches', 'outlet', 'date'));
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
