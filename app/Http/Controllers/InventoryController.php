<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $inventories = Inventory::with('category')->when($request->search != null || $request->search != '', function ($query) use($request) {
            $query -> where('name', 'like', "%$request->search%");
        })->paginate(10);
        $categories = Category::all();
        return Inertia::render('Inventory/Index',[
            'categories' => $categories,
            'inventories' => $inventories,
            'search' => $request->search ?? '',
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
            'name' => ['required', 'max:255', 'unique:inventories']
        ]);

        Inventory::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'details' => $request->details,
            'details->quantity' => 0
        ]);

        return Redirect::back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function show(Inventory $inventory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function edit(Inventory $inventory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'max:255']
        ]);

        $inventory = Inventory::find($id);
        $inventory->update([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'details' => $request->details
        ]);

        return Redirect::back();
    }

    public function update_quantity(Request $request, $id)
    {
        // $request->validate([
        //     'details->quantity' => ['required']
        // ]);

        $inventory = Inventory::find($id);
        $current_quan = $inventory->details['quantity']??0;
        $result = $current_quan + $request->details['quantity'];

        $inventory->update([
            'details->quantity' => $result
        ]);

        return Redirect::back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $inventory = Inventory::find($id);
        $inventory->delete();

        return Redirect::back();
    }
}
