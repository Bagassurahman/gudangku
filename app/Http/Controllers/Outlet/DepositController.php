<?php

namespace App\Http\Controllers\Outlet;

use App\Account;
use App\ActivityLog;
use App\CashJournal;
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
        $date = Carbon::now()->toDateString();

        $account = Account::where('user_id', Auth::user()->id)->first();

        $depostie = Deposit::whereDate('deposit_date', $date)
            ->where('account_number', $account->account_number)
            ->first();


        if (!$depostie) {
            $account = Account::where('user_id', Auth::user()->id)->first();
            $warehouse = Outlet::where('user_id', Auth::user()->id)->first();

            $omset = DB::table('transactions')
                ->where('outlet_id', Auth::user()->id)
                ->whereDate('order_date', $date)
                ->sum('total');

            $online = DB::table('transactions')
                ->where('outlet_id', Auth::user()->id)
                ->whereDate('order_date', $date)
                ->where('customer_type', 'online')
                ->where('payment_method', 'qris')
                ->sum('total');

            $shoppe_pay = DB::table('transactions')
                ->where('outlet_id', Auth::user()->id)
                ->whereDate('order_date', $date)
                ->where('payment_method', 'qris')
                ->whereNotIn('customer_type', ['online'])
                ->whereIn('customer_type', ['umum', 'member'])
                ->sum('total');

            $totalCash = DB::table('cash_journal_details')
                ->join('cash_journals', 'cash_journal_details.cash_journal_id', '=', 'cash_journals.id')
                ->whereDate('cash_journals.date', $date)
                ->where('cash_journals.user_id', Auth::user()->id)
                ->sum('cash_journal_details.debit');

            $amount = $omset - $online - $shoppe_pay - $totalCash;

            $depo = Deposit::create([
                'deposit_number' => 'DEPO' . date('Ymd') . sprintf('%06d', mt_rand(1, 999999)),
                'deposit_date' => $date,
                'warehouse_id' => $warehouse->warehouse_id,
                'outlet_id' => Auth::user()->id,
                'account_number' => $account->account_number,
                'amount' => $amount,
                'omset' => $omset,
                'online' => $online,
                'shoppe_pay' => $shoppe_pay,
                'cash_journal' => $totalCash,
                'status' => 'waiting'
            ]);
        } else {
            $omset = DB::table('transactions')
                ->where('outlet_id', Auth::user()->id)
                ->whereDate('order_date', $date)
                ->sum('total');

            $online = DB::table('transactions')
                ->where('outlet_id', Auth::user()->id)
                ->whereDate('order_date', $date)
                ->where('customer_type', 'online')
                ->where('payment_method', 'qris')
                ->sum('total');

            $shoppe_pay = DB::table('transactions')
                ->where('outlet_id', Auth::user()->id)
                ->whereDate('order_date', $date)
                ->where('payment_method', 'qris')
                ->whereNotIn('customer_type', ['online'])
                ->whereIn('customer_type', ['umum', 'member'])
                ->sum('total');

            $totalCash = DB::table('cash_journal_details')
                ->join('cash_journals', 'cash_journal_details.cash_journal_id', '=', 'cash_journals.id')
                ->whereDate('cash_journals.date', $date)
                ->where('cash_journals.user_id', Auth::user()->id)
                ->sum('cash_journal_details.debit');

            $amount = $omset - $online - $shoppe_pay - $totalCash;

            $depostie->update([
                'omset' => $omset,
                'online' => $online,
                'shoppe_pay' => $shoppe_pay,
                'cash_journal' => $totalCash,
                'amount' => $amount
            ]);
        }

        $depositsQuery = Deposit::where('account_number', Auth::user()->account->account_number);

        if ($request->filled('tanggal_mulai') && $request->filled('tanggal_akhir')) {
            $tanggalMulai = Carbon::parse($request->input('tanggal_mulai'))->startOfDay();
            $tanggalAkhir = Carbon::parse($request->input('tanggal_akhir'))->endOfDay();

            $depositsQuery->whereBetween('created_at', [$tanggalMulai, $tanggalAkhir]);
        }

        $deposits = $depositsQuery->get();

        // Log
        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'action' => 'Mengakses menu deposit',
            'details' => 'Mengakses menu deposit'
        ]);

        return view('outlet.deposit.index', compact('deposits'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Log
        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'action' => 'Mengakses menu tambah deposit',
            'details' => 'Mengakses menu tambah deposit'
        ]);

        return view('outlet.deposit.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $date = Carbon::now()->toDateString();

        $currentDate = Carbon::now();
        $monthYear = $currentDate->format('Y-m');

        $account = Account::where('user_id', Auth::user()->id)->first();
        $warehouse = Outlet::where('user_id', Auth::user()->id)->first();


        $deposit = Deposit::where('id', $id)
            ->where('account_number', $account->account_number)
            ->firstOrFail();

        $existingRecord = Riche::where('date', 'LIKE', $monthYear . '%')
            ->where('outlet_id', Auth::user()->id)
            ->first();

        if ($existingRecord) {
            $existingRecord->update([
                'total' => $existingRecord->total + $deposit->amount
            ]);
        } else {
            Riche::create([
                'outlet_id' => Auth::user()->id,
                'date' => $monthYear,
                'total' => $deposit->amount,
                'debit' => 0,
                'sub_total' => $deposit->amount
            ]);
        }

        $deposit->update([
            'status' => 'pending'
        ]);

        // log
        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'action' => 'Menambah data deposit',
            'details' => 'Menambah data deposit'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $deposit = Deposit::findOrFail($id);
        $depositDate = $deposit->deposit_date;


        $transactionDetails = DB::table('transaction_details')
            ->join('products', 'transaction_details.product_id', '=', 'products.id')
            ->join('transactions', 'transaction_details.transaction_id', '=', 'transactions.id')
            ->selectRaw('transaction_details.qty, transaction_details.price, products.name, transactions.*')
            ->where('outlet_id', Auth::user()->id)
            ->whereDate('transactions.order_date', $depositDate)
            ->get();

        $jurnalCash =
            DB::table('cash_journals')
            ->join('outlets', 'cash_journals.user_id', '=', 'outlets.user_id')
            ->join('cash_journal_details', 'cash_journals.id', '=', 'cash_journal_details.cash_journal_id')
            ->join('costs', 'cash_journal_details.cost_id', '=', 'costs.id') // Menambahkan join dengan tabel 'costs'
            ->select(
                'cash_journals.date',
                'cash_journals.code',
                'outlets.outlet_name',
                'outlets.user_id',
                'cash_journal_details.*',
                'costs.name as cost_name', // Menambahkan kolom 'name' dari tabel 'costs'
                'cash_journal_details.debit'
            )
            ->groupBy('outlets.outlet_name', 'cash_journals.date', 'outlets.user_id', 'cash_journal_details.id', 'costs.name') // Menambahkan kolom 'costs.name' ke dalam gruping
            ->where('cash_journals.date', $depositDate)
            ->where('outlets.user_id', Auth::user()->id)
            ->orderBy('cash_journals.date')
            ->get();

        // Log
        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'action' => 'Mengakses menu detail deposit',
            'details' => 'Mengakses menu detail deposit'
        ]);

        return view('outlet.deposit.show', compact('deposit', 'transactionDetails', 'jurnalCash'));
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
