<?php

namespace App\Http\Controllers\Outlet;

use App\CashJournal;
use App\CashJournalDetail;
use App\Cost;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert as SweetAlert;

class CashJournalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = CashJournal::where('user_id', Auth::user()->id)->with(['detail', 'detail.cost']);

        if ($request->filled('tanggal_mulai') && $request->filled('tanggal_akhir')) {
            $tanggalMulai = $request->input('tanggal_mulai');
            $tanggalAkhir = $request->input('tanggal_akhir');

            $query->whereDate('date', '>=', $tanggalMulai)
                ->whereDate('date', '<=', $tanggalAkhir);
        } elseif ($request->filled('tanggal_mulai')) {
            $tanggalMulai = $request->input('tanggal_mulai');

            $query->whereDate('date', '>=', $tanggalMulai);
        }

        $journals = $query->get();

        return view('outlet.cash-journal.index', compact('journals'));
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $costs = Cost::all();

        return view('outlet.cash-journal.create', compact('costs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $data = $request->all();
        $user_id = Auth::user()->id;
        $code = 'CASH' . date('Ymd') . sprintf('%06d', mt_rand(1, 999999));

        $cashJournal = CashJournal::create([
            'user_id' => $user_id,
            'code' => $code,
            'date' => $data['date'],
        ]);

        // Simpan detail jurnal kas
        $cashJournalDetails = [];
        $additional_costs = $data['additional_costs'];
        $notes = $data['notes'];
        $amounts = $data['amounts'];

        for ($i = 0; $i < count($additional_costs); $i++) {
            if (!empty($additional_costs[$i])) {
                $cashJournalDetails[] = new CashJournalDetail([
                    'cash_journal_id' => $cashJournal->id,
                    'cost_id' => $additional_costs[$i],
                    'notes' => $notes[$i],
                    'debit' => $amounts[$i]
                ]);
            }
        }

        // Simpan semua detail jurnal kas sekaligus
        $cashJournal->detail()->saveMany($cashJournalDetails);

        SweetAlert::success('Berhasil', 'Jurnal kas berhasil dibuat');

        return redirect()->route('outlet.jurnal-kas.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $journal = CashJournal::with('detail')->find($id);
        return view('outlet.cash-journal.show', compact('journal'));
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
