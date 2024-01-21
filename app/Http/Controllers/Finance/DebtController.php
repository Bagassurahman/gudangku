<?php

namespace App\Http\Controllers\Finance;

use App\ActivityLog;
use App\Debt;
use App\Http\Controllers\Controller;
use App\Riche;
use Carbon\Carbon;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert as SweetAlert;
use Illuminate\Support\Facades\DB;

class DebtController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $debts = Debt::with(['outlet', 'warehouse'])->orderBy('status', 'desc')->orderBy('date', 'desc')->get();

        $tanggalMulai = $request->input('tanggal_mulai');
        $tanggalAkhir = $request->input('tanggal_akhir');
        
        $query = Debt::with(['outlet', 'warehouse'])
            ->orderBy('status', 'desc')
            ->orderBy('date', 'desc');
        
        if ($tanggalMulai && $tanggalAkhir) {
            $query->whereBetween('date', [$tanggalMulai, $tanggalAkhir]);
        } elseif ($tanggalMulai) {
            $query->whereDate('date', '>=', $tanggalMulai);
        }
        
        $debts = $query->get();

        $wait = $query->where('status', 'on_progres')->sum('amount');

        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'action' => 'Mengakses menu hutang',
            'details' => 'Mengakses menu hutang'
        ]);

        return view('finance.debt.index', compact('debts', 'wait'));
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

        if (!$riche) {
            SweetAlert::error('Gagal', 'Kekayaan Outlet Tidak Cukup');
        } elseif ($riche->total < $debt->amount) {
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


        // log
        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'action' => 'Melunasi hutang',
            'details' => 'Melunasi hutang'
        ]);

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
