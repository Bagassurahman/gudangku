<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index($id)
    {
        $products = Product::findOrFail($id);

        return response()->json(
            $products
        );
    }
}
