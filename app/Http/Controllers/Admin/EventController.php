<?php

namespace App\Http\Controllers\Admin;

use App\Event;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEventRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert as SweetAlert;


class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = Event::all();

        return view('admin.event.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.event.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEventRequest $request)
    {

        $data = $request->all();
        $data['slug'] = Str::slug($request->name);
        $data['image'] = $request->file('image')->store(
            'assets/event',
            'public'
        );

        Event::create($data);

        SweetAlert::success('Berhasil', 'Data Event Berhasil Ditambahkan');
        return redirect()->route('admin.event.index');
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
        $event = Event::findOrFail($id);

        return view('admin.event.edit', compact('event'));
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
        $event = Event::findOrFail($id);

        $data = $request->all();

        if ($request->file('image')) {
            $data['image'] = $request->file('image')->store(
                'assets/event',
                'public'
            );
        } else {
            unset($data['image']);
        }

        $data['slug'] = Str::slug($request->name);

        $event->update($data);

        SweetAlert::success('Berhasil', 'Data Event Berhasil Diubah');

        return redirect()->route('admin.event.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $event = Event::findOrFail($id);

        $event->delete();

        SweetAlert::success('Berhasil', 'Data Event Berhasil Dihapus');

        return redirect()->route('admin.event.index');
    }
}
