<?php

namespace App\Http\Controllers\Admin;

use App\ActivityLog;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\MaterialData;
use App\Product;
use App\ProductDetail;
use Illuminate\Http\Request;
use Gate;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert as SweetAlert;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('product_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');


        $products = Product::with('details')->get();

        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'action' => 'Mengakses menu produk',
            'details' => 'Mengakses menu produk'
        ]);

        return view('admin.product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(Gate::denies('product_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');


        $materials = MaterialData::all();

        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'action' => 'Mengakses menu tambah produk',
            'details' => 'Mengakses menu tambah produk'
        ]);

        return view('admin.product.create', compact('materials'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request)
    {
        $product = new Product([
            'name' => $request->name,
            'general_price' => $request->general_price,
            'member_price' => $request->member_price,
            'online_price' => $request->online_price,
            'image' => $request->file('image')->store('assets/product', 'public'),
            'point' => $request->point
        ]);

        // Simpan produk baru ke database
        $product->save();

        // Simpan detail produk ke database
        // Looping untuk menyimpan data detail produk
        for ($i = 0; $i < count($request->materials); $i++) {
            $detail = new ProductDetail([
                'product_id' => $product->id,
                'material_id' => $request->materials[$i],
                'dose' => $request->takaran[$request->materials[$i]]
            ]);

            // Simpan detail produk ke database
            $detail->save();
        }

        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'action' => 'Menambahkan produk baru',
            'details' => 'Menambahkan produk baru dengan nama ' . $product->name
        ]);

        SweetAlert::toast('Produk berhasil ditambahkan', 'success')->timerProgressBar();

        return redirect()->route('admin.produk.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort_if(Gate::denies('product_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $product = Product::with('details')->find($id);

        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'action' => 'Mengakses detail produk',
            'details' => 'Mengakses detail produk ' . $product->name
        ]);

        return view('admin.product.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_if(Gate::denies('product_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $product = Product::find($id);

        $materials = MaterialData::all();

        $productDetails = $product->details()->with('material')->get();

        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'action' => 'Mengakses menu edit produk',
            'details' => 'Mengakses menu edit produk ' . $product->name
        ]);




        return view('admin.product.edit', compact('product', 'productDetails', 'materials'));
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
        $product = Product::findOrFail($id);
        $product->name = $request->name;
        $product->general_price = $request->general_price;
        $product->member_price = $request->member_price;
        $product->online_price = $request->online_price;
        $product->point = $request->point;

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            Storage::disk('public')->delete($product->image);

            // Simpan gambar baru
            $product->image = $request->file('image')->store('assets/product', 'public');
        }

        // Simpan perubahan pada produk
        $product->save();

        // Simpan detail produk ke database
        // Hapus semua detail produk terkait produk ini
        ProductDetail::where('product_id', $product->id)->delete();

        // Looping untuk menyimpan data detail produk
        if ($request->has('materials') && $request->has('takaran')) {
            for ($i = 0; $i < count($request->materials); $i++) {
                $detail = new ProductDetail([
                    'product_id' => $product->id,
                    'material_id' => $request->materials[$i],
                    'dose' => $request->takaran[$request->materials[$i]]
                ]);

                // Simpan detail produk ke database
                $detail->save();
            }
        }

        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'action' => 'Mengubah produk',
            'details' => 'Mengubah produk ' . $product->name
        ]);

        SweetAlert::toast('Produk berhasil diperbarui', 'success')->timerProgressBar();

        return redirect()->route('admin.produk.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_if(Gate::denies('product_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $product = Product::find($id);

        $product->delete();

        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'action' => 'Menghapus produk',
            'details' => 'Menghapus produk ' . $product->name
        ]);

        SweetAlert::toast('Produk berhasil dihapus', 'success')->timerProgressBar();

        return redirect()->route('admin.produk.index');
    }
}
