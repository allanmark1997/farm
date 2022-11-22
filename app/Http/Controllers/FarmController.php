<?php

namespace App\Http\Controllers;

use App\Models\Farm;
use App\Models\Farmer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class FarmController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $farms = Farm::with('farmer')->when($request->selected_farmer != null || $request->selected_farmer != 'all', function ($query, $value) {
            $query->where(['farmer_id' => $value]);
        })->get();
        $farmers = Farmer::where(['active'=> true])->get();
        return Inertia::render('Farm/Index',[
            'farms' => $farms,
            'farmers' => $farmers,
            'selected_farmer' => $request->selected_farmer ?? 'all'
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
        Farm::create([
            'farmer_id' => $request->selected_farmer,
            'income' => 0,
            'details' => $request->details
        ]);

        return Redirect::back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Farm  $farm
     * @return \Illuminate\Http\Response
     */
    public function show(Farm $farm)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Farm  $farm
     * @return \Illuminate\Http\Response
     */
    public function edit(Farm $farm)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Farm  $farm
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $farm = Farm::find($id);
        $farm->update([
            'map_id' => $request->map_id,
            'farmer_id' => $request->farmer_id,
            'details' => $request->details
        ]);

        return Redirect::back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Farm  $farm
     * @return \Illuminate\Http\Response
     */
    public function destroy(Farm $id)
    {
        $farm = Farm::find($id);
        $farm->delete();

        return Redirect::back();
    }

    public function farms(Request $request, $farmer_id)
    {
        $farms = Farm::where(['farmer_id' => $farmer_id])->get();
        return Inertia::render('Farmer/Farms',[
            'farms' => $farms
        ]);
    }
}
