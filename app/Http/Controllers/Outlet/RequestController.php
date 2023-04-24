<?php

namespace App\Http\Controllers\Outlet;

use App\Http\Controllers\Controller;
use App\MaterialData;
use App\Outlet;
use App\Request as ModelRequest;
use App\RequestDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert as SweetAlert;

class RequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $requests = ModelRequest::where('outlet_id', Auth::user()->id)->get();

        return view('outlet.request.index', compact('requests'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $materials = MaterialData::all();

        return view('outlet.request.create', compact('materials'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $outlet = Outlet::where('user_id', Auth::user()->id)->first();

        $newRequest = new ModelRequest([
            'outlet_id' => Auth::user()->id,
            'warehouse_id' => $outlet->warehouse_id,
            'code' => $request->code,
            'status' => 'pending',
        ]);

        $newRequest->save();

        if (is_array($request->materials)) {
            foreach ($request->materials as $material) {
                $detail = new RequestDetail([
                    'request_id' => $newRequest->id,
                    'material_id' => $material,
                    'qty' => $request->qty[$material],
                ]);

                // Save product detail to database
                $detail->save();
            }
        }

        SweetAlert::success('Success', 'Request has been sent');

        return redirect()->route('outlet.request.index');
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


        return view('outlet.request.show', compact('request'));
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
