<?php

namespace App\Http\Controllers\Outlet;

use App\Account;
use App\Deposit;
use App\Http\Controllers\Controller;
use App\Outlet;
use App\Riche;
use App\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        $depositsQuery = Deposit::where('account_number', Auth::user()->account->account_number);

        if ($request->filled('tanggal_mulai') && $request->filled('tanggal_akhir')) {
            $tanggalMulai = Carbon::parse($request->input('tanggal_mulai'))->startOfDay();
            $tanggalAkhir = Carbon::parse($request->input('tanggal_akhir'))->endOfDay();

            $depositsQuery->whereBetween('created_at', [$tanggalMulai, $tanggalAkhir]);
        }

        $deposits = $depositsQuery->get();

        return view('outlet.deposit.index', compact('deposits'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('outlet.deposit.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $date = Carbon::now()->toDateString();

        $currentDate = Carbon::now();
        $monthYear = $currentDate->format('Y-m');

        $account = Account::where('user_id', Auth::user()->id)->first();
        $warehouse = Outlet::where('user_id', Auth::user()->id)->first();


        $omset = DB::table('transactions')
            ->whereDate('order_date', $date)
            ->sum('total');

        $online = DB::table('transactions')
            ->whereDate('order_date', $date)
            ->where('customer_type', 'online')
            ->where('payment_method', 'qris')
            ->sum('total');

        $shoppe_pay = DB::table('transactions')
            ->whereDate('order_date', $date)
            ->where('payment_method', 'qris')
            ->sum('total');

        $totalCash = DB::table('cash_journal_details')
            ->join('cash_journals', 'cash_journal_details.cash_journal_id', '=', 'cash_journals.id')
            ->whereDate('cash_journals.date', $date)
            ->sum('cash_journal_details.debit');

        $amount = $omset - $online - $shoppe_pay - $totalCash;

        Deposit::create([
            'deposit_number' => 'DEPO' . date('Ymd') . sprintf('%06d', mt_rand(1, 999999)),
            'deposit_date' => $date,
            'warehouse_id' => $warehouse->warehouse_id,
            'outlet_id' => Auth::user()->id,
            'account_number' => $account->account_number,
            'amount' => $amount,
            'omset' => $omset,
            'online' => $online,
            'shoppe_pay' => $shoppe_pay,
            'cash_journal' => $totalCash
        ]);


        $existingRecord = Riche::where('date', 'LIKE', $monthYear . '%')->first();

        if ($existingRecord) {
            $existingRecord->update([
                'total' => $existingRecord->total + $amount
            ]);
        } else {
            Riche::create([
                'outlet_id' => Auth::user()->id,
                'date' => $monthYear,
                'total' => $amount,
                'debit' => 0,
                'sub_total' => $amount
            ]);
        }


        SweetAlert::success('Berhasil', 'Setoran berhasil, tunggu konfirmasi dari gudang');

        return redirect()->back();
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
