<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\PurchaseOfMaterials;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseOfMaterialReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $query = PurchaseOfMaterials::join('purchase_of_materials_details', 'purchase_of_materials.id', '=', 'purchase_of_materials_details.purchase_of_materials_id')
            ->select(DB::raw('purchase_of_materials.po_date, SUM(purchase_of_materials_details.total) as total'))
            ->groupBy('purchase_of_materials.po_date')
            ->orderBy('purchase_of_materials.po_date');

        $tanggalMulai = $request->input('tanggal_mulai');
        $tanggalAkhir = $request->input('tanggal_akhir');

        if ($request->filled('tanggal_mulai') && $request->filled('tanggal_akhir')) {
            $query->whereDate('purchase_of_materials.po_date', '>=', $tanggalMulai)
                ->whereDate('purchase_of_materials.po_date', '<=', $tanggalAkhir);
        } elseif ($request->filled('tanggal_mulai')) {
            $query->whereDate('purchase_of_materials.po_date', '>=', $tanggalMulai);
        }

        $purchases = $query->get();

        foreach ($purchases as $purchase) {
            $date = Carbon::parse($purchase->po_date)->format('d F Y');
            $purchase->po_date = $date;
        }

        return view('finance.purchase-report.index', compact('purchases'));
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

        $purchaseDetails = PurchaseOfMaterials::join('purchase_of_materials_details', 'purchase_of_materials.id', '=', 'purchase_of_materials_details.purchase_of_materials_id')
            ->join('users', 'purchase_of_materials.warehouse_id', '=', 'users.id')
            ->select('purchase_of_materials.warehouse_id', 'users.warehouse_name', 'purchase_of_materials.po_date', DB::raw('SUM(purchase_of_materials_details.total) as total_purchase'))
            ->where('purchase_of_materials.po_date', $newDate)
            ->groupBy('users.id', 'users.warehouse_name', 'purchase_of_materials.po_date')
            ->get();

        return view('finance.purchase-report.show', [
            'purchaseDetails' => $purchaseDetails,
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

    public function showDetail($date, $warehouseId)
    {
        $newDate = date('Y-m-d', strtotime($date));

        $purchaseDetails = PurchaseOfMaterials::join('purchase_of_materials_details', 'purchase_of_materials.id', '=', 'purchase_of_materials_details.purchase_of_materials_id')
            ->join('material_data', 'purchase_of_materials_details.material_id', '=', 'material_data.id')
            ->select(DB::raw('MAX(purchase_of_materials.warehouse_id) as warehouse_id'), 'material_data.name as material_name', DB::raw('SUM(purchase_of_materials_details.qty) as total_quantity'), DB::raw('MAX(purchase_of_materials_details.price) as price'), DB::raw('SUM(purchase_of_materials_details.qty * purchase_of_materials_details.price) as total_price'))
            ->where('purchase_of_materials.po_date', $newDate)
            ->where('purchase_of_materials.warehouse_id', $warehouseId)
            ->groupBy('material_data.id')
            ->get();





        return view('finance.purchase-report.detail', [
            'purchaseDetails' => $purchaseDetails,
            'date' => $date,
            'warehouse' => DB::table('users')
                ->select('warehouse_name')
                ->where('id', $warehouseId)
                ->first()
        ]);
    }
}
