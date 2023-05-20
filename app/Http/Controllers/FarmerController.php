<?php

namespace App\Http\Controllers;

use App\Models\Farm;
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
    public function index(Request $request)
    {
        $farmers = Farmer::when($request->search != null || $request->seach != '', function($query) use($request){
            $query -> where("name", "like", "%$request->search%");
        })->paginate(10);

        return Inertia::render('Farmer/Index', [
            'farmers' => $farmers,
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
            'pic2x2' => ['required'],
            // 'uploadSignature'=> ['required'],
            // 'uploadThumbamark'=> ['required'],
            // 'uploadSignatureCaptain'=> ['required'],
            // 'uploadSignatureAgriculture'=> ['required'],
            // 'uploadSignatureCADC'=> ['required'],

            'details.fname' => ['required', 'max:255'],
            'details.sname' => ['required', 'max:255'],
            // 'details.ename' => ['required'],
            'details.gender' => ['required'],
            'details.mobile' => ['required'],
            'details.dateBirth' => ['required'],
            'details.regionBirth' => ['required'],
            'details.provinceBirth' => ['required'],
            'details.cityBirth' => ['required'],
            'details.baranggayBirth' => ['required'],
            'details.regionAddress' => ['required'],
            'details.provinceAddress' => ['required'],
            'details.cityAddress' => ['required'],
            'details.baranggayAddress' => ['required'],
            'details.status' => ['required'],
            'details.motherName' => ['required'],
            'details.houseHold' => ['required'],
            'details.householdLiving' => ['required'],
            'details.numberMale' => ['required'],
            'details.numberFemale' => ['required'],
            'details.formalEducational' => ['required'],
            'details.pwd' => ['required'],
            'details.fourPs' => ['required'],
            'details.IndigenousGoup' => ['required'],
            'details.emergencyPerson' => ['required'],
            'details.emergencyContact' => ['required'],
            'details.grossFarming' => ['required'],
            'details.grossNonFarming' => ['required'],
            'details.grossParcel' => ['required'],
            'details.grossARB' => ['required'],
            'details.dateApplicant' => ['required'],
            'details.nameOfApplicant' => ['required'],
        ]);

        $details = $request->details;

        // if($request->hasfile('uploadSignature')){
        //     $photo = $request->file('uploadSignature');
        //     $imageName = 'applicant_'.Str::random(10).'.'.$photo->extension();
        //     $photo->move(public_path().'/images/farmer/', $imageName); 
        //     $details['uploadSignature'] = $imageName;  
        // }

        // if($request->hasfile('uploadThumbamark')){
        //     $photo = $request->file('uploadThumbamark');
        //     $imageName = 'thumbmark_applicant_'.Str::random(10).'.'.$photo->extension();
        //     $photo->move(public_path().'/images/farmer/', $imageName); 
        //     $details['uploadThumbamark'] = $imageName;  
        // }

        // if($request->hasfile('uploadSignatureCaptain')){
        //     $photo = $request->file('uploadSignatureCaptain');
        //     $imageName = 'brgy_captain_'.Str::random(10).'.'.$photo->extension();
        //     $photo->move(public_path().'/images/farmer/', $imageName); 
        //     $details['uploadSignatureCaptain'] = $imageName;  
        // }

        // if($request->hasfile('uploadSignatureAgriculture')){
        //     $photo = $request->file('uploadSignatureAgriculture');
        //     $imageName = 'city_agriculture_'.Str::random(10).'.'.$photo->extension();
        //     $photo->move(public_path().'/images/farmer/', $imageName); 
        //     $details['uploadSignatureAgriculture'] = $imageName;  
        // }

        // if($request->hasfile('uploadSignatureCADC')){
        //     $photo = $request->file('uploadSignatureCADC');
        //     $imageName = 'cafc_chhairman_'.Str::random(10).'.'.$photo->extension();
        //     $photo->move(public_path().'/images/farmer/', $imageName); 
        //     $details['uploadSignatureCADC'] = $imageName;  
        // }

        if($request->hasfile('pic2x2')){
            $photo = $request->file('pic2x2');
            $imageName = 'pic2x2'.Str::random(10).'.'.$photo->extension();
            $photo->move(public_path().'/images/farmer/', $imageName); 
            $details['pic2x2'] = $imageName;  
        }

        Farmer::create([
            'name' => $details['fname'] ." ".($details['mname'] ?? "")." ".($details['sname'] ?? "")." ".($details['ename'] ?? ""),
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
            'details.fname' => ['required', 'max:255']
        ]);

        $details = $request->details;

        if($request->hasfile('uploadSignature')){
            $photo = $request->file('uploadSignature');
            $imageName = 'applicant_'.Str::random(10).'.'.$photo->extension();
            $photo->move(public_path().'/images/farmer/', $imageName); 
            $details['uploadSignature'] = $imageName;  
        }

        if($request->hasfile('uploadThumbamark')){
            $photo = $request->file('uploadThumbamark');
            $imageName = 'thumbmark_applicant_'.Str::random(10).'.'.$photo->extension();
            $photo->move(public_path().'/images/farmer/', $imageName); 
            $details['uploadThumbamark'] = $imageName;  
        }

        if($request->hasfile('uploadSignatureCaptain')){
            $photo = $request->file('uploadSignatureCaptain');
            $imageName = 'brgy_captain_'.Str::random(10).'.'.$photo->extension();
            $photo->move(public_path().'/images/farmer/', $imageName); 
            $details['uploadSignatureCaptain'] = $imageName;  
        }

        if($request->hasfile('uploadSignatureAgriculture')){
            $photo = $request->file('uploadSignatureAgriculture');
            $imageName = 'city_agriculture_'.Str::random(10).'.'.$photo->extension();
            $photo->move(public_path().'/images/farmer/', $imageName); 
            $details['uploadSignatureAgriculture'] = $imageName;  
        }

        if($request->hasfile('uploadSignatureCADC')){
            $photo = $request->file('uploadSignatureCADC');
            $imageName = 'cafc_chhairman_'.Str::random(10).'.'.$photo->extension();
            $photo->move(public_path().'/images/farmer/', $imageName); 
            $details['uploadSignatureCADC'] = $imageName;  
        }

        if($request->hasfile('pic2x2')){
            $photo = $request->file('pic2x2');
            $imageName = 'pic2x2'.Str::random(10).'.'.$photo->extension();
            $photo->move(public_path().'/images/farmer/', $imageName); 
            $details['pic2x2'] = $imageName;  
        }
        
         
        $farmer = Farmer::find($id);
        $farmer->update([
            'name' => $details['fname'] ." ".($details['mname'] ?? "")." ".($details['sname'] ?? "")." ".($details['ename'] ?? ""),
            'details' => $details
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
        $farmers = Farmer::paginate(10);
        return Inertia::render('Farmer/Index', [
            'farmers' => $farmers
        ]);
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
        $farmer = Farmer::with('transactions','parcels')->where('id',$request->id)->first();
        $parcels = [];
        foreach ($farmer->parcels as $parcel) {
            $key = $parcel->barangay.'_'.$parcel->details['ownership_document_no'].'_'.$parcel->details['farm_ownership'].'_'.$parcel->details['farm_owner'];
            if (!isset($parcels[$key])) {
                $parcels[$key] = [
                    'description' => [
                        'total_farm_area' => 0,
                        'barangay' => $parcel->barangay,
                        'ownership_document_no' => $parcel->details['ownership_document_no'],
                        'farm_ownership' => $parcel->details['farm_ownership'],
                        'farm_owner' => $parcel->details['farm_owner'],
                    ],
                    'farms' => []
                ];
            }
            $parcels[$key]['farms'][] = $parcel;
            $parcels[$key]['description']['total_farm_area'] += floatval($parcel->details['farm_size']);
        }
        $parcels = collect($parcels)->values()->all(); //update the keys
        return Inertia::render('Farmer/FarmerProfile', [
            'farmer' => $farmer,
            'parcels' => $parcels
        ]);
    }

    public function add_farmer_page(){
        return Inertia::render('Farmer/AddFarmer');
    }
} 
