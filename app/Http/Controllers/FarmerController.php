<?php

namespace App\Http\Controllers;

use App\Models\Farmer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Inertia\Inertia;

class FarmerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $farmers = Farmer::paginate(10);

        return Inertia::render('Farmer/Index', [
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
        $request->validate([
            'name' => ['required', 'max:255']
        ]);

        $details = $request->details;

        if($request->hasfile('applicant_signature')){
            $details['applicant_signatures'] = [];
            foreach($request->file('photos') as $photo){
                $imageName = 'applicant_'.Str::random(10).'.'.$photo->extension();
                $photo->move(public_path().'/images/farmer/', $imageName); 
                array_push($images, $imageName);
                $details['applicant_signatures'][] = $imageName;
            }
        }
        if($request->hasfile('applicant_thumbmark')){
            $details['applicant_thumbmarks'] = [];
            foreach($request->file('photos') as $photo){
                $imageName = 'thumbmark_applicant_'.Str::random(10).'.'.$photo->extension();
                $photo->move(public_path().'/images/farmer/', $imageName); 
                array_push($images, $imageName);
                $details['applicant_thumbmarks'][] = $imageName;
            }
        }
        if($request->hasfile('brgy_captain_signature')){
            $details['brgy_captain_signatures'] = [];
            foreach($request->file('photos') as $photo){
                $imageName = 'brgy_captain_'.Str::random(10).'.'.$photo->extension();
                $photo->move(public_path().'/images/farmer/', $imageName); 
                array_push($images, $imageName);
                $details['brgy_captain_signatures'][] = $imageName;
            }
        }
        if($request->hasfile('city_agriculture_signature')){
            $details['brgy_captain_signatures'] = [];
            foreach($request->file('photos') as $photo){
                $imageName = 'city_agriculture_'.Str::random(10).'.'.$photo->extension();
                $photo->move(public_path().'/images/farmer/', $imageName); 
                array_push($images, $imageName);
                $details['brgy_captain_signatures'][] = $imageName;
            }
        }
        if($request->hasfile('cafc_chhairman_signature')){
            $details['cafc_chhairman_signatures'] = [];
            foreach($request->file('photos') as $photo){
                $imageName = 'cafc_chhairman_'.Str::random(10).'.'.$photo->extension();
                $photo->move(public_path().'/images/farmer/', $imageName); 
                array_push($images, $imageName);
                $details['cafc_chhairman_signatures'][] = $imageName;
            }
        }

        Farmer::create([
            'name' => $request->name,
            'income' => 0,
            'active' => true,
            'details' => $details
        ]);

        return Redirect::back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Farmer  $farmer
     * @return \Illuminate\Http\Response
     */
    public function show(Farmer $farmer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Farmer  $farmer
     * @return \Illuminate\Http\Response
     */
    public function edit(Farmer $farmer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Farmer  $farmer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'max:255']
        ]);
        
        $farmer = Farmer::find($id);
        $farmer->update([
            'name' => $request->name,
            'income' => $request->income
        ]);

        return Redirect::back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Farmer  $farmer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $farmer = Farmer::find($id);
        $farmer->delete();

        return Redirect::back();
    }

    public function toggle_status($id)
    {
        $farmer = Farmer::find($id);
        $farmer->update([
            'active' => $farmer->active == '1' ? '0' : '1'
        ]);

        return Redirect::back();
    }

    public function profile(Request $request){
        $farmer = Farmer::where('id',$request->id)->get();
        return Inertia::render('Farmer/FarmerProfile', [
            'farmer' => $farmer
        ]);
    }

    public function add_farmer_page(){
        return Inertia::render('Farmer/AddFarmer');
    }
} 
