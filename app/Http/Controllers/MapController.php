<?php

namespace App\Http\Controllers;

use App\Models\Map;
use App\Models\Farmer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class MapController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $maps = Map::all();
        $farmers = Farmer::all();
        return Inertia::render('Map/Index',[
            'maps' => $maps,
            'farmers' => $farmers
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
        // $request->validate([
        //     'name' => ['required', 'max:255']
        // ]);

        Map::create([
            'farmer_id' => $request->farmer_id,
            'details' => $request->details
        ]);

        return Redirect::back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Map  $map
     * @return \Illuminate\Http\Response
     */
    public function show(Map $map)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Map  $map
     * @return \Illuminate\Http\Response
     */
    public function edit(Map $map)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Map  $map
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $map = Map::find($id);
        $map->update([
            'farmer_id' => $request->farmer_id,
            'details' => $request->details
        ]);

        return Redirect::back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Map  $map
     * @return \Illuminate\Http\Response
     */
    public function destroy(Map $map)
    {
        //
        $data = Map::whereCode($map)->first();
        $data->delete();
        return Redirect::back();
    }
}
