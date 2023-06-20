<?php

namespace App\Http\Controllers\Finance;

use App\Deposit;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DepositReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Deposit::selectRaw('deposits.deposit_date, SUM(deposits.amount) as total')
            ->groupBy('deposits.deposit_date')
            ->orderBy('deposits.deposit_date');

        if ($request->filled('tanggal_mulai') && $request->filled('tanggal_akhir')) {
            $tanggalMulai = $request->input('tanggal_mulai');
            $tanggalAkhir = $request->input('tanggal_akhir');

            $query->whereDate('deposits.deposit_date', '>=', $tanggalMulai)
                ->whereDate('deposits.deposit_date', '<=', $tanggalAkhir);
        } elseif ($request->filled('tanggal_mulai')) {
            $tanggalMulai = $request->input('tanggal_mulai');

            $query->whereDate('deposits.deposit_date', '>=', $tanggalMulai);
        }

        $deposits = $query->get();

        foreach ($deposits as $deposit) {
            $date = Carbon::parse($deposit->deposit_date)->format('d F Y');
            $deposit->deposit_date = $date;
        }

        return view('finance.deposit-report.index', compact('deposits'));
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
    public function show($date)
    {
        $newDate = date('Y-m-d', strtotime($date));

        $deposits = Deposit::join('accounts', 'deposits.account_number', '=', 'accounts.account_number')
            ->with('account.user.outlet')
            ->select('accounts.account_number', DB::raw('SUM(deposits.amount) as total'))
            ->whereDate('deposits.deposit_date', $newDate)
            ->groupBy('accounts.account_number')
            ->get();


        return view('finance.deposit-report.show', [
            'deposits' => $deposits,
            'date' => $date
        ]);
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

    public function showDetail($date, $accountNumber)
    {
        $newDate = date('Y-m-d', strtotime($date));

        $deposits = Deposit::join('accounts', 'deposits.account_number', '=', 'accounts.account_number')
            ->with('account.user.outlet')
            ->select('deposits.*', 'accounts.account_number', DB::raw('SUM(deposits.amount) as total'))
            ->whereDate('deposits.deposit_date', $newDate)
            ->where('accounts.account_number', $accountNumber)
            ->groupBy('deposits.id', 'accounts.account_number')
            ->get();


        return view('finance.deposit-report.detail', [
            'outlet' => $deposits[0]->account->user->outlet->outlet_name,
            'deposits' => $deposits,
            'date' => $date
        ]);
    }
}
