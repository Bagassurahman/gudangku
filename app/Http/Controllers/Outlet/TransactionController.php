<?php

namespace App\Http\Controllers\Outlet;

use App\Http\Controllers\Controller;
use App\Inventory;
use App\Transaction;
use App\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert as SweetAlert;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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
        $cartItems = json_decode($request->input('cart_items'), true);

        $transaction = Transaction::create([
            'order_number' => 'TRX-' . date('YmdHis'),
            'order_date' => date('Y-m-d H:i:s'),
            'outlet_id' => Auth::user()->id,
            'paid_amount' => $request->input('paid_amount'),
        ]);

        foreach ($cartItems as $cartItem) {
            TransactionDetail::create([
                'transaction_id' => $transaction->id,
                'product_id' => $cartItem['id'],
                'qty' => $cartItem['count'],
                'price' => $cartItem['price'],
                'total' => $cartItem['total'],
            ]);
        }

        // get stock material and update
        foreach ($cartItems as $cartItem) {
            $productId = $cartItem['id'];

            $details = DB::table('product_details')
                ->join('material_data', 'product_details.material_id', '=', 'material_data.id')
                ->where('product_details.product_id', '=', $productId)
                ->select('product_details.material_id', 'material_data.name as material_name', 'product_details.dose')
                ->get();

            foreach ($details as $detail) {

                $amount = Inventory::where('outlet_id', Auth::user()->id)
                    ->where('material_data_id', $detail->material_id)
                    ->select('entry_amount', 'exit_amount')
                    ->first();

                $jumlah_masuk = $amount->entry_amount;
                $jumlah_keluar = $amount->exit_amount;

                // hitung jumlah keluar baru
                $jumlah_keluar_baru = $detail->dose * $cartItem['count'];

                // hitung jumlah sisa
                $jumlah_sisa = $jumlah_masuk - ($jumlah_keluar + $jumlah_keluar_baru);

                // update jumlah sisa dan jumlah keluar
                Inventory::where('outlet_id', Auth::user()->id)
                    ->where('material_data_id', $detail->material_id)
                    ->update([
                        'remaining_amount' => $jumlah_sisa,
                        'exit_amount' => $jumlah_keluar + $jumlah_keluar_baru,
                    ]);
            }
        }





        SweetAlert::success(
            'Transaksi Berhasil',
            'Kembalian : Rp. ' . number_format($request->input('paid_amount') - $request->input('total_price'), 0, ',', '.')
        );

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
