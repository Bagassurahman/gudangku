<?php

namespace App\Http\Controllers\Warehouse;

use App\ActivityLog;
use App\Debt;
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
use App\UnitData;
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

        $requests = ModelRequest::with('details.material')
            ->where('warehouse_id', Auth::user()->id)
            ->latest()
            ->paginate(10); // Ubah jumlah item per halaman sesuai kebutuhan Anda

        // Menghitung total harga langsung dalam kueri database
        $requests->each(function ($request) {
            $request->totalHarga = $request->details->sum(function ($detail) {
                return $detail->material->selling_price * $detail->qty;
            });
        });

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
        $request = ModelRequest::with('details.material')->where('id', $id)->get();

        $totalHarga = 0;

        foreach ($request[0]->details as $detail) {
            $material = $detail->material;
            $totalHarga += $material->selling_price * $detail->qty;
        }


        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'action' => 'Mengakses detail Permintaan Distribusi',
            'details' => 'Mengakses detail Permintaan Distribusi'
        ]);


        return view('warehouse.distibution-request.show', compact('request', 'totalHarga'));
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

        $status_updated = false;

        foreach ($details->all() as $index => $detail) {
            $id = $detail->id;
            $material_id = $detail->material_id;
            $qty = $detail->qty;
            $updated_qty = $request->input('updated_qty')[$index];

            $inventory = Inventory::where('warehouse_id', Auth::user()->id)
                ->where('material_data_id', $material_id)
                ->first();

            $status_updated = false;

            if ($inventory) {
                $stock = $inventory->remaining_amount;

                if ($stock >= $updated_qty) {
                    $qty = $updated_qty;

                    if (!$status_updated) {
                        $requests->status = 'approved';
                        $status_updated = true;
                    }
                } else {
                    $requests->status = 'pending';
                    $status_updated = true;

                    $material = MaterialData::find($material_id);

                    if ($material) {
                        $material_name = $material->name;
                        SweetAlert::error('Gagal', 'Stok ' . $material_name . ' kurang');
                    }
                }
            } else {
                $requests->status = 'pending';
                $status_updated = true;

                $material = MaterialData::find($material_id);

                if ($material) {
                    $material_name = $material->name;
                    SweetAlert::error('Gagal', 'Stok ' . $material_name . ' kurang');
                }
            }

            $detail->qty = $updated_qty;
            $detail->save();
        }


        $requests->save();

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
                $materialData = MaterialData::where('id', $detail->material_id)->first();
                $unit = UnitData::where('id', $materialData->unit_id)->first();

                DistributionDetail::create([
                    'distribution_id' => $distribution->id,
                    'material_id' => $detail->material_id,
                    'quantity' => $detail->qty,
                    'total' => $detail->qty * $materialData->selling_price
                ]);
            }

            $total_akhir = 0;

            foreach ($details->all() as $detail) {
                $materialData = MaterialData::where('id', $detail->material_id)->first();
                $total_akhir += $detail->qty * $materialData->selling_price;
            }

            Debt::create([
                'outlet_id' => $requests->outlet_id,
                'warehouse_id' => Auth::user()->id,
                'date' => date('Y-m-d'),
                'amount' => $total_akhir,
                'status' => 'pending'
            ]);

            SweetAlert::success('Berhasil', 'Distribusi berhasil');
        }

        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'action' => 'Mengubah status Permintaan Distribusi',
            'details' => 'Mengubah status Permintaan Distribusi'
        ]);

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

    public function reject(Request $request)
    {
        $requests = ModelRequest::where('id', $request->id)->first();

        $requests->status = 'rejected';
        $requests->save();

        SweetAlert::success('Berhasil', 'Permintaan ditolak');

        // log
        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'action' => 'Menolak Permintaan Distribusi',
            'details' => 'Menolak Permintaan Distribusi'
        ]);

        return redirect()->route('warehouse.data-request-bahan.index');
    }
}
