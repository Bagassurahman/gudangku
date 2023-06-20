<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CashJournalReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = DB::table('cash_journals')
            ->join('outlets', 'cash_journals.user_id', '=', 'outlets.user_id')
            ->join('cash_journal_details', 'cash_journals.id', '=', 'cash_journal_details.cash_journal_id')
            ->select('cash_journals.date', DB::raw('SUM(cash_journal_details.debit) as total_debit'))
            ->groupBy('cash_journals.date')
            ->orderBy('cash_journals.date');




        if ($request->filled('tanggal_mulai') && $request->filled('tanggal_akhir')) {
            $tanggalMulai = $request->input('tanggal_mulai');
            $tanggalAkhir = $request->input('tanggal_akhir');

            $query->whereDate('cash_journals.date', '>=', $tanggalMulai)
                ->whereDate('cash_journals.date', '<=', $tanggalAkhir);
        } elseif ($request->filled('tanggal_mulai')) {
            $tanggalMulai = $request->input('tanggal_mulai');

            $query->whereDate('cash_journals.date', '>=', $tanggalMulai);
        }

        $cashJournals = $query->get();


        foreach ($cashJournals as $cashJournal) {
            $date = Carbon::parse($cashJournal->date)->format('d F Y');
            $cashJournal->date = $date;
        }
        return view('finance.cash-journal-report.index', compact('cashJournals'));
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

        $query = DB::table('cash_journals')
            ->join('outlets', 'cash_journals.user_id', '=', 'outlets.user_id')
            ->join('cash_journal_details', 'cash_journals.id', '=', 'cash_journal_details.cash_journal_id')
            ->select('cash_journals.date', 'outlets.outlet_name', 'outlets.user_id', DB::raw('SUM(cash_journal_details.debit) as total_debit'))
            ->groupBy('outlets.outlet_name', 'cash_journals.date', 'outlets.user_id')
            ->where('cash_journals.date', $newDate)
            ->orderBy('cash_journals.date');

        $cashJournals = $query->get();


        return view('finance.cash-journal-report.show', [
            'cashJournals' => $cashJournals,
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

    public function showDetail($date, $outletId)
    {
        $newDate = date('Y-m-d', strtotime($date));

        $query = DB::table('cash_journals')
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
                DB::raw('SUM(cash_journal_details.debit) as total_debit')
            )
            ->groupBy('outlets.outlet_name', 'cash_journals.date', 'outlets.user_id', 'cash_journal_details.id', 'costs.name') // Menambahkan kolom 'costs.name' ke dalam gruping
            ->where('cash_journals.date', $newDate)
            ->where('outlets.user_id', $outletId)
            ->orderBy('cash_journals.date');



        $cashJournals = $query->get();


        return view('finance.cash-journal-report.detail', [
            'outlet' => $cashJournals[0]->outlet_name,
            'cashJournals' => $cashJournals,
            'date' => $date,
        ]);
    }
}
