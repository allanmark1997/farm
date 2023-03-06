<?php

namespace App\Http\Controllers;

use App\Exports\ChartExport;
use App\Models\Category;
use App\Models\Farm;
use App\Models\Farmer;
use App\Models\Inventory;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Illuminate\Database\Eloquent\Builder;


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
        $farmers = Farmer::when($request->search_farmer != null && $request->search_farmer != '', function ($query) use ($request) {
                $query->where('name', 'like', "%$request->search_farmer%");
        })->where(['active'=> true])->get();
        $categories = Category::all();
        $inventories = [
            'seedling' => Inventory::with('category')->where('category_id', 1)->get(),
            'fertilizer' => Inventory::with('category')->where('category_id', 2)->get(),
        ];
        return Inertia::render('Farm/Index',[
            'farms' => $farms,
            'farmers' => $farmers,
            'selected_farmer' => $request->selected_farmer ?? '',
            'search_farmer' => $request->search_farmer ?? '',
            'categories' => $categories,
            'inventories' => $inventories,
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
            'barangay' => ['required'],
            'map.name' => ['required'],
            'details.farm_owner' => ['required'],
            'details.farm_ownership' => ['required'],
            'details.farm_type_business' => ['required'],
            'details.farm_size' => ['required', 'integer'],
            'details.ownership_document_no' => ['required'],
            'details.organic_practitioner' => ['required'],
        ]);

        $details = $request->details;
        $details['inventories'] = ['seedling' => null, 'seedling_quantity'=> 0, 'fertilizer' => []];
        $details['expected_income'] = 0;
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

        $request->validate([
            'details.inventories.seedling' => ['required'],
            'details.inventories.seedling_quantity' => ['required'],
            'details.expected_income' => ['required'],
            'plant_at' => ['required'],
        ]);
        $farm = Farm::find($id);
        
        $farm->update([
            'status' => 'farming',
            'details->inventories' => $request->details['inventories'], //['expected_income' => 100, 'income' => 0, 'inventories'=> ['seedling' => 'Corn', 'fertilizers' => ['fert1', 'fert2']]]
            'map->color' => $request->color,
            'details->expected_income' => $request->details['expected_income'],
        ]);

        Transaction::create([
            'farmer_id' => $farm->farmer->id,
            'plant_at' => $request->plant_at,
            'farm_id' => $farm->id,
            'user_id' => Auth::user()->id,
            'type' => 'plant',
            'details' => $request->details
        ]);

        return Redirect::back();
    }

    public function harvest(Request $request, $id)
    {
        $request->validate([
            'harvest_at' => ['required']
        ]);
        $farm = Farm::find($id);
        $inventories = $farm->details['inventories'];
        $income = $farm->income + $request->details['income'];
        $farm->update([
            'status' => 'idle',
            'income' => $income,
            'details->income' => $income, //update the income
            'details->expected_income' => 0, //update the income
            'details->inventories' => ['seedling' => null, 'seedling_quantity'=>0, 'fertilizer' => []],
            'map->color' => $request->color //default color
        ]);
        $farmer = $farm->farmer;
        
        $farmer->update([
            'income' => $farmer->income + $request->details['income']
        ]);
        $details = $request->details;
        $details['inventories'] = $inventories;
        $plant = Transaction::where(['farm_id' => $farm->id, 'harvest_at' => null])->first();
        $plant->update([
            'harvest_at' => $request->harvest_at,
            'details' => $details //sync details
        ]);
        //harvest transaction
        Transaction::create([
            'farmer_id' => $farm->farmer->id,
            'plant_at' => $plant->plant_at,
            'harvest_at' => $request->harvest_at,
            'farm_id' => $farm->id,
            'user_id' => Auth::user()->id,
            'type' => 'harvest',
            'details' => $details //update the income
        ]);
        return Redirect::back();
    }


    public function index_analysis(Request $request)
    {
        return Inertia::render('Analysis/Index',[
            'transactions' => $this->reports_data($request->date_from, $request->date_to),
            'date_from' => $request->date_from ?? '',
            'date_to' => $request->date_to ?? ''
        ]);
    }

    public function download_report(Request $request) {
        $transactions = $this->reports_data($request->date_from, $request->date_to);
        $results = [];
        $results[] = ['Barangay', 'Seeds', 'Fertilizers'];
        foreach ($transactions as $barangay => $transaction) {
            $results[] = [$barangay, $transaction['seeds'], $transaction['fertilizers']];
        }
        return (new ChartExport([$results], ['Reports']))->download("Results.xlsx");
    }

    public function reports_data($from, $to) {
        $transactions = [];
        $farms = Farm::all();
        foreach ($farms->groupBy('barangay') as $barangay => $farms) {
            $transactions[$barangay] = [
                'seeds' => 0,
                'fertilizers' => 0
            ];
            foreach ($farms as $farm) {
                
                $plants = Transaction::where(['farm_id' => $farm->id, 'type' => 'plant'])->when($from != null && $from != '' && $to != null && $to != '', function ($query) use ($from, $to) {
                    $query->whereBetween('plant_at', [$from, $to]);
                })->get();
                
                foreach ($plants as $plant) {
                    //count how many seeds
                    $transactions[$barangay]['seeds'] += $plant->details['inventories']['seedling_quantity'];
                    //count just how many fertilizers
                     
                    foreach($plant->details['inventories']['fertilizer'] as $fertilizer)
                    {
                        $transactions[$barangay]['fertilizers'] += $fertilizer['quantity'];
                    }
                }
            }
        }

        return $transactions;
    }
}
