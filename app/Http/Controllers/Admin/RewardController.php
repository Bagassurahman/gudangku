<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRewardRequest;
use App\Reward;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert as SweetAlert;


class RewardController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rewards = Reward::all();

        return view('admin.reward.index', compact('rewards'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.reward.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRewardRequest $request)
    {
        try {
            Reward::create($request->all());

            SweetAlert::toast('Data Reward Berhasil Ditambahkan', 'success');
        } catch (\Exception $e) {
            SweetAlert::toast('Data Reward Gagal Ditambahkan', 'error');
        }

        return redirect()->route('admin.reward.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $reward = Reward::findOrFail($id);

        return view('admin.reward.show', compact('reward'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $reward = Reward::findOrFail($id);

        return view('admin.reward.edit', compact('reward'));
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
        try {
            $reward = Reward::findOrFail($id);

            $reward->update($request->all());

            SweetAlert::toast('Data Reward Berhasil Diubah', 'success');
        } catch (\Exception $e) {
            SweetAlert::toast('Data Reward Gagal Diubah', 'error');
        }

        return redirect()->route('admin.reward.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $reward = Reward::findOrFail($id);

            $reward->delete();


            SweetAlert::toast('Data Reward Berhasil Dihapus', 'success');
        } catch (\Exception $e) {
            SweetAlert::toast('Data Reward Gagal Dihapus', 'error');
        }

        return redirect()->route('admin.reward.index');
    }
}
