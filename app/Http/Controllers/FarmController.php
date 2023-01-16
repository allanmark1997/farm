<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Farm;
use App\Models\Farmer;
use App\Models\Inventory;
use App\Models\Transaction;
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

        $farms = Farm::with('farmer')->when($request->selected_farmer != null && $request->selected_farmer != 'all', function ($query) use ($request) {
            $query->where(['farmer_id' => $request->selected_farmer]);
        })->get();
        $farmers = Farmer::where(['active'=> true])->get();
        $categories = Category::all();
        $inventories = [
            'seedling' => Inventory::with('category')->where('category_id', 1)->get(),
            'fertilizer' => Inventory::with('category')->where('category_id', 2)->get(),
        ];
        return Inertia::render('Farm/Index',[
            'farms' => $farms,
            'farmers' => $farmers,
            'selected_farmer' => $request->selected_farmer ?? 'all',
            'categories' => $categories,
            'inventories' => $inventories
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
            'details' => $request->details, 
            'map' => $request->map
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
            // 'map_id' => $request->map_id,
            'farmer_id' => $request->farmer_id,
            'details' => $request->details,
            'map' => $request->map, 
            'status' => 'idle',
        ]);

        return Redirect::back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Farm  $farm
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
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

    public function plant(Request $request, $id)
    {
        $farm = Farm::find($id);
        
        $farm->update([
            'status' => 'farming',
            'details' => $request->details, //['expected_income' => 100, 'income' => 0, 'inventories'=> ['seedling' => 'Corn', 'fertilizers' => ['fert1', 'fert2']]]
            'map->color' => $request->color
        ]);

        Transaction::create([
            'farmer_id' => $farm->farmer->id,
            'farm_id' => $farm->id,
            'user_id' => Auth::user()->id,
            'type' => 'plant',
            'details' => $request->details
        ]);

        return Redirect::back();
    }

    public function harvest(Request $request, $id)
    {
        $farm = Farm::find($id);
        $farm->update([
            'status' => 'idle',
            'details' => $request->details, //update the income
            'map->color' => $request->color //default color
        ]);
        $farmer = $farm->farmer;
        $farmer->update([
            'income' => $farmer->income + $farm->details['expected_income']
        ]);

        Transaction::create([
            'farmer_id' => $farm->farmer->id,
            'farm_id' => $farm->id,
            'user_id' => Auth::user()->id,
            'type' => 'harvest',
            'details' => $request->details //update the income
        ]);
        return Redirect::back();
    }
}
