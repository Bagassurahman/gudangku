<?php

namespace App\Http\Controllers\Finance;

use App\Account;
use App\ActivityLog;
use App\Balance;
use App\Deposit;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
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
        $status = ['pending', 'success'];

        $query = Deposit::whereIn('status', $status)
            ->orderBy('deposit_date', 'desc');

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

        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'action' => 'Mengakses menu setor kas',
            'details' => 'Mengakses menu setor kas'
        ]);

        return view('finance.deposit.index', compact('deposits'));
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

        $deposit = Deposit::findOrFail($id);
        $depositDate = $deposit->deposit_date;


        $transactionDetails = DB::table('transaction_details')
            ->join('products', 'transaction_details.product_id', '=', 'products.id')
            ->join('transactions', 'transaction_details.transaction_id', '=', 'transactions.id')
            ->selectRaw('transaction_details.qty, transaction_details.price, products.name, transactions.*')
            ->where('outlet_id', $deposit->outlet_id)
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
            ->where('outlets.user_id', $deposit->outlet_id)
            ->orderBy('cash_journals.date')
            ->get();

        // log
        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'action' => 'Mengakses menu detail setor kas',
            'details' => 'Mengakses menu detail setor kas'
        ]);

        return view('finance.deposit.show', compact('deposit', 'transactionDetails', 'jurnalCash'));
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

        // log
        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'action' => 'Melakukan konfirmasi setor kas',
            'details' => 'Melakukan konfirmasi setor kas'
        ]);

        $deposit->update([
            'status' => 'success'
        ]);
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
