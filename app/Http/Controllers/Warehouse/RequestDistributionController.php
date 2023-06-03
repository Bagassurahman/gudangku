<?php

namespace App\Http\Controllers\Warehouse;

use App\Distribution;
use App\DistributionDetail;
use App\Http\Controllers\Controller;
use App\Inventory;
use App\MaterialData;
use Illuminate\Http\Request;
use Gate;
use Symfony\Component\HttpFoundation\Response;
use App\Request as ModelRequest;
use App\RequestDetail;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert as SweetAlert;
use SebastianBergmann\Diff\Differ;

class RequestDistributionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('request_distribution_acces'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $requests = ModelRequest::where('warehouse_id', Auth::user()->id)->get();

        return view('warehouse.distibution-request.index', compact('requests'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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
        $request = ModelRequest::findOrFail($id);


        return view('warehouse.distibution-request.show', compact('request'));
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

        $requests = ModelRequest::find($id);

        $details = $requests->details;


        // tambahkan variabel flag untuk menandakan apakah status sudah diubah
        $status_updated = false;

        foreach ($details->all() as $detail) {
            $id = $detail->id;
            $material_id = $detail->material_id;
            $qty = $detail->qty;

            // check stock di inventori
            $inventory = Inventory::where('warehouse_id', Auth::user()->id)
                ->where('material_data_id', $material_id)
                ->first();

            if ($inventory) {
                $stock = $inventory->remaining_amount;

                if ($stock >= $qty) {
                    $inventory->remaining_amount = $stock - $qty;
                    $inventory->exit_amount = $inventory->exit_amount + $qty;
                    $inventory->save();

                    // ubah status hanya jika belum diubah sebelumnya
                    if (!$status_updated) {
                        $requests->status = 'approved';
                        $status_updated = true;
                    }
                } else {
                    // ubah status hanya jika belum diubah sebelumnya
                    if (!$status_updated) {
                        $requests->status = 'rejected';
                        $status_updated = true;

                        SweetAlert::error('Gagal', 'Stok tidak mencukupi');
                    }
                }
            } else {
                // ubah status hanya jika belum diubah sebelumnya
                if (!$status_updated) {
                    $requests->status = 'rejected';
                    $status_updated = true;

                    SweetAlert::error('Gagal', 'Stok tidak mencukupi');
                }
            }
        }

        // simpan status
        $requests->save();

        // buat data distribution jika request disetujui
        if ($requests->status == 'approved') {


            $distribution = Distribution::create([
                'warehouse_id' => Auth::user()->id,
                'distribution_number' => 'DIS' . date('Ymd') . sprintf('%06d', mt_rand(1, 999999)),
                'outlet_id' => $requests->outlet_id,
                'distribution_date' => date('Y-m-d'),
                'fee' => $request->fee,
                'status' => 'on_progres'
            ]);

            foreach ($details->all() as $detail) {
                $materialData = MaterialData::where(
                    'id',
                    $detail->material_id
                )->first();


                DistributionDetail::create([
                    'distribution_id' => $distribution->id,
                    'material_id' => $detail->material_id,
                    'quantity' => $detail->qty,
                    'total' => $detail->qty * $materialData->selling_price
                ]);

                $inventoryOutlet = Inventory::where('outlet_id', $requests->outlet_id)->where('material_data_id', $detail->material_id)->first();

                if ($inventoryOutlet) {
                    $inventoryOutlet->update([
                        'entry_amount' => $inventoryOutlet->entry_amount + $detail->qty,
                        'remaining_amount' => $inventoryOutlet->remaining_amount + $detail->qty
                    ]);
                } else {
                    Inventory::create([
                        'outlet_id' => $requests->outlet_id,
                        'material_data_id' => $detail->material_id,
                        'entry_amount' => $detail->qty,
                        'remaining_amount' => $detail->qty
                    ]);
                }
            }

            SweetAlert::success('Berhasil', 'Distribusi berhasil');
        }

        return redirect()->route('warehouse.data-request-bahan.index');
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
