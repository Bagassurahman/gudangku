<?php

namespace App\Http\Controllers\Warehouse;

use App\Http\Controllers\Controller;
use App\PurchaseOfMaterials;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PurchaseReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $purchases = PurchaseOfMaterials::join('purchase_of_materials_details', 'purchase_of_materials.id', '=', 'purchase_of_materials_details.purchase_of_materials_id')
            ->select(DB::raw('purchase_of_materials.po_date, SUM(purchase_of_materials_details.total) as total'))
            ->where('purchase_of_materials.warehouse_id', Auth::user()->id)
            ->groupBy('purchase_of_materials.po_date')
            ->orderBy('purchase_of_materials.po_date')
            ->get();

        foreach ($purchases as $purchase) {
            $date = Carbon::parse($purchase->po_date)->format('d F Y');
            $purchase->po_date = $date;
        }

        return view('warehouse.purchase-report.index', [
            'purchases' => $purchases
        ]);
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
            ->join('material_data', 'purchase_of_materials_details.material_id', '=', 'material_data.id')
            ->select('purchase_of_materials.po_date', 'material_data.name as material_name', 'purchase_of_materials_details.qty', 'purchase_of_materials_details.price', 'purchase_of_materials_details.total')
            ->where('purchase_of_materials.po_date', $newDate)
            ->get();

        return view('warehouse.purchase-report.show', [
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
}
