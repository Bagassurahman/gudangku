<?php

namespace App\Http\Controllers\Warehouse;

use App\Http\Controllers\Controller;
use App\Inventory;
use App\MaterialData;
use App\PurchaseOfMaterials;
use App\PurchaseOfMaterialsDetail;
use App\Supplier;
use App\UnitData;
use Illuminate\Http\Request;
use Gate;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use RealRashid\SweetAlert\Facades\Alert as SweetAlert;

class PurchaseOfMaterialController extends Controller
{

    public function index()
    {
        abort_if(Gate::denies('purchase_of_material_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $suppliers = Supplier::all();
        $materials = MaterialData::with('unit')->get();

        return view('warehouse.purchase-of-material.index', compact('suppliers', 'materials'));
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

        $purchaseOfMaterial = PurchaseOfMaterials::create([
            'po_number' => 'PO' . sprintf('%06d', mt_rand(1, 999999)),
            'supplier_id' => $request->supplier_id,
            'po_date' => $request->po_date,
            'warehouse_id' => Auth::user()->id,
        ]);

        foreach ($cartItems as $cartItem) {
            $inventory = Inventory::where('material_data_id', $cartItem['id'])
                ->where('warehouse_id', Auth::user()->id)
                ->first();

            $material = MaterialData::where('id', $cartItem['id'])
                ->first();


            PurchaseOfMaterialsDetail::create([
                'purchase_of_materials_id' => $purchaseOfMaterial->id,
                'material_id' => $cartItem['id'],
                'qty' => $cartItem['count'],
                'price' => $cartItem['price'],
                'total' => $cartItem['total'],
            ]);

            if ($inventory) {
                $inventory->update([
                    'entry_amount' => $inventory->entry_amount + $cartItem['count'],
                    'remaining_amount' => $inventory->remaining_amount + $cartItem['count'],
                    'hpp' => (intval($inventory->hpp) * intval($inventory->entry_amount) + intval($cartItem['total'])) / ($inventory->entry_amount + $cartItem['count']),

                ]);
            } else {
                Inventory::create([
                    'material_data_id' => $cartItem['id'],
                    'warehouse_id' => Auth::user()->id,
                    'entry_amount' => $cartItem['count'],
                    'remaining_amount' => $cartItem['count'],
                    'hpp' => $cartItem['price'],

                ]);
            }
        }


        SweetAlert::success('Berhasil', 'Pembelian bahan berhasil ditambahkan');





        return redirect()->route('warehouse.pembelian-bahan.index');
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
