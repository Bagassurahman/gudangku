<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Inventory;
use App\Outlet;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function getOutletInventory($id)
    {
        $inventory = Inventory::where('outlet_id', $id)->with(['material', 'material.unit'])->get();

        return response()->json($inventory);
    }
}
