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
        $request->validate([
            'barangay' => ['required', 'max:255']
        ]);

        $details = $request->details;
        $details['inventories'] = ['seedling' => null, 'seedling_quantity'=> 0, 'fertilizer' => []];
        Farm::create([
            'farmer_id' => $request->selected_farmer,
            'income' => 0,
            'details' => $details, 
            'map' => $request->map,
            'barangay' => $request->barangay
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
            // 'farmer_id' => $request->farmer_id,
            // 'details' => $request->details,
            'map' => $request->map, 
            // 'barangay' => $request->barangay, 
            // 'status' => 'idle',
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
            'details->inventories' => $request->details['inventories'], //['expected_income' => 100, 'income' => 0, 'inventories'=> ['seedling' => 'Corn', 'fertilizers' => ['fert1', 'fert2']]]
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
        // dd($request->details['income']);
        $farm = Farm::find($id);
        $inventories = $farm->details['inventories'];
        $income = $farm->details['income'] + $request->details['income'];
        $farm->update([
            'status' => 'idle',
            'income' => $income,
            'details->income' => $income, //update the income
            'details->inventories' => ['seedling' => null, 'seedling_quantity'=>0, 'fertilizer' => []],
            'map->color' => $request->color //default color
        ]);
        $farmer = $farm->farmer;
        
        $farmer->update([
            'income' => $farmer->income + $request->details['income']
        ]);
        $details = $request->details;
        $details['inventories'] = $inventories;
        Transaction::create([
            'farmer_id' => $farm->farmer->id,
            'farm_id' => $farm->id,
            'user_id' => Auth::user()->id,
            'type' => 'harvest',
            'details' => $details //update the income
        ]);
        return Redirect::back();
    }


    public function index_analysis(Request $request)
    {
        $transactions = [];//Transaction::all();
        $farms = Farm::all();
        foreach ($farms->groupBy('barangay') as $barangay => $farms) {
            $transactions[$barangay] = [
                'seeds' => 0,
                'fertilizers' => 0
            ];
            foreach ($farms as $farm) {
                
                $harvests = Transaction::where(['farm_id' => $farm->id, 'type' => 'plant'])->get();
                foreach ($harvests as $harvest) {
                    //count how many seeds
                    $transactions[$barangay]['seeds'] += $harvest->details['inventories']['seedling_quantity'];
                    //count just how many fertilizers
                     
                    foreach($harvest->details['inventories']['fertilizer'] as $fertilizer)
                    {
                        $transactions[$barangay]['fertilizers'] += $fertilizer['quantity'];
                    }
                /* foreach ($harvest->details['inventories']['fertilizer'] as $fertilizer) {
                        $transactions[$barangay]['fertilizers'] += 1;
                    } */
                }
            }
        }
        return Inertia::render('Analysis/Index',[
            'transactions' => $transactions,
        ]);
    }
}
