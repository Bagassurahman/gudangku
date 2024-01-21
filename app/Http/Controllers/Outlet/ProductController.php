<?php

namespace App\Http\Controllers\Outlet;

use App\ActivityLog;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function getProductDetails(Request $request)
    {
        $productId = $request->input('id');

        // melakukan query ke tabel product_details untuk mendapatkan informasi bahan dan dosis
        $details = DB::table('product_details')
            ->join('material_data', 'product_details.material_id', '=', 'material_data.id')
            ->where('product_details.product_id', '=', $productId)
            ->select('product_details.material_id', 'material_data.name as material_name', 'product_details.dose')
            ->get();


        return response()->json($details);
    }

    public function getProductStockByMaterial(Request $request)
    {
        // melakukan query ke tabel inventory untuk mendapatkan informasi persediaan bahan
        $inventory = DB::table('inventories')
            ->where('material_data_id', '=', $request->input('material_id'))
            ->where('outlet_id', '=', Auth::user()->id)
            ->select('remaining_amount')
            ->first();

        // cek apakah data persediaan ditemukan
        if ($inventory) {
            return response()->json($inventory->remaining_amount);
        } else {
            return response()->json(0);
        }
    }


    public function reduceProductStockByMaterial(Request $request)
    {
        // melakukan query ke tabel inventory untuk mengurangi persediaan bahan
        $inventory = DB::table('inventories')
            ->where('material_data_id', $request->input('material_id'))
            ->where('outlet_id', Auth::user()->id)
            ->update(['remaining_amount' => DB::raw('remaining_amount - ' . $request->input('dose'))]);

        return response()->json($inventory);
    }

    public function increaseProductStockByMaterial(Request $request)
    {
        $inventory = DB::table('inventories')
            ->where('material_data_id', $request->input('material_id'))
            ->where('outlet_id', Auth::user()->id)
            ->update(['remaining_amount' => DB::raw('remaining_amount + ' . $request->input('dose'))]);


        return response()->json($inventory);
    }

    public function getStockByInventory(Request $request)
    {
        $productDetails = DB::table('product_details')
            ->select('material_id', 'dose')
            ->where('product_id', $request->product_id)
            ->get();

        $materialIds = $productDetails->pluck('material_id')->toArray();

        $inventory = DB::table('inventories')
            ->whereIn('material_data_id', $materialIds)
            ->where('outlet_id', Auth::user()->id)
            ->get();

        $remainingStock = PHP_INT_MAX;

        foreach ($productDetails as $productDetail) {
            $materialId = $productDetail->material_id;
            $dose = $productDetail->dose;

            $inventoryItem = $inventory->firstWhere('material_data_id', $materialId);

            if ($inventoryItem) {
                $remainingAmount = $inventoryItem->remaining_amount;
                $requiredAmount = $productDetail->dose;

                $stockBahan = floor($remainingAmount / $requiredAmount);
                $remainingStock = min($remainingStock, $stockBahan);
            } else {
                $remainingStock = 0;
                break;
            }
        }



        return response()->json(['stockByMaterial' => $remainingStock]);
    }
}
