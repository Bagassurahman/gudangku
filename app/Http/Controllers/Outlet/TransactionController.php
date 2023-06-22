<?php

namespace App\Http\Controllers\Outlet;

use App\Http\Controllers\Controller;
use App\Inventory;
use App\Product;
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
            'total' => $request->total_price,
            'paid_amount' => $request->input('paid_amount'),
            'payment_method' => $request->tipe_pembayaran,
            'customer_type' => $request->tipe_harga
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
        // $productMessage = "Detail Pembelian: \n";
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

            // $product = Product::find($cartItem['id']);
            // $productMessage .=  "\n";
            // $productMessage .= "Nama Produk: " . $product->name . "\n";
            // $productMessage .= "Harga: Rp "  . number_format($cartItem['price'], 0, ',', '.') . "\n";
            // $productMessage .= "Jumlah: " . $cartItem['count'] . "\n";
            // $productMessage .= "\n";
        }

        // $curl = curl_init();
        // $token = "3U5JIicbIcIWHZxugBRU";
        // $url = "https://api.fonnte.com/send";

        // curl_setopt_array($curl, array(
        //     CURLOPT_URL => $url,
        //     CURLOPT_RETURNTRANSFER => true,
        //     CURLOPT_ENCODING => '',
        //     CURLOPT_MAXREDIRS => 10,
        //     CURLOPT_TIMEOUT => 0,
        //     CURLOPT_FOLLOWLOCATION => true,
        //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        //     CURLOPT_CUSTOMREQUEST => 'POST',
        //     CURLOPT_POSTFIELDS => array(
        //         'target' => '6282220422308',
        //         'type' => 'text',
        //         'message' => 'Tes Struk Belanja Di Zam-zam Time. ' . "\n" . "\n" . $productMessage . 'Total: Rp ' . number_format($request->total_price, 0, ',', '.') . "\n" . 'Jumlah Bayar: Rp ' . number_format($request->input('paid_amount'), 0, ',', '.') . "\n" . 'Kembalian: Rp ' . number_format(($request->input('paid_amount') - $request->total_price), 0, ',', '.')
        //     ),
        //     CURLOPT_HTTPHEADER => array(
        //         'Authorization: ' . $token
        //     ),
        //     CURLOPT_SSL_VERIFYHOST => 0,
        //     CURLOPT_SSL_VERIFYPEER => false,
        // ));

        // $response = curl_exec($curl);

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
