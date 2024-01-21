<?php

namespace App\Http\Controllers\Api;

use App\ActivityLog;
use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index($id)
    {
        $products = Product::findOrFail($id);

        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'action' => 'Mengakses menu produk',
            'details' => 'Mengakses menu produk'
        ]);

        return response()->json(
            $products
        );
    }
}
