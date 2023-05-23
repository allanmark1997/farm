<?php

namespace App\Http\Controllers;

use App\Exports\ChartExport;
use App\Models\Transaction;
use Carbon\Carbon;
use Faker\Guesser\Name;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Database\Eloquent\Builder;
use Inertia\Inertia;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $from = $request->date_from;
        $to = $request->date_to;
        $transactions = Transaction::where('type', 'plant')->orderBy('id','DESC')->with('farmer')->with('farm')->with('user')->where('is_inputed', 0)->when($from != null && $from != '' && $to != null && $to != '', function ($query) use ($from, $to) {
            $query->whereBetween('plant_at', [$from, $to]);
        })->when($request->search != null && $request->search!= '' && $request->category == 0, function ($query) use ($request) {
            $query->whereHas('farmer', function (Builder $query) use ($request) {
                $query->where('name', 'like', "%$request->search%");
            });
        })->when($request->search != null && $request->search!= '' && $request->category == 1, function ($query) use ($request) {
            $query->whereHas('farm', function (Builder $query) use ($request){
                $query->where('map->name', 'like', "%$request->search%");
            });
        })->when($request->search != null && $request->search!= ''&& $request->category == 2, function ($query) use ($request) {
            $query->whereHas('farm', function (Builder $query) use ($request){
                $query->where('barangay', $request->search);
            });
        })->paginate(10); 
        return Inertia::render('Transaction/Index',[
            'transactions' => $transactions,
            'search' => $request->search ?? '',
            'filter_view' => $request->category ?? 0,
            'date_from' => $request->date_from ?? '',
            'date_to' => $request->date_to ?? ''
        ]);
    }

    public function download_transactions(Request $request) 
    {
        $from = $request->date_from;
        $to = $request->date_to;
        $transaction = Transaction::where('type', 'plant')->orderBy('id','DESC')->with('farmer')->with('farm')->with('user')->where('is_inputed', 0)->when($from != null && $from != '' && $to != null && $to != '', function ($query) use ($from, $to) {
            $query->whereBetween('plant_at', [$from, $to]);
        })->when($request->search != null && $request->search!= '' && $request->category == 0, function ($query) use ($request) {
            $query->whereHas('farmer', function (Builder $query) use ($request) {
                $query->where('name', 'like', "%$request->search%");
            });
        })->when($request->search != null && $request->search!= '' && $request->category == 1, function ($query) use ($request) {
            $query->whereHas('farm', function (Builder $query) use ($request){
                $query->where('map->name', 'like', "%$request->search%");
            });
        })->when($request->search != null && $request->search!= ''&& $request->category == 2, function ($query) use ($request) {
            $query->whereHas('farm', function (Builder $query) use ($request){
                $query->where('barangay', $request->search);
            });
        })->get();
        
        $results = [];
        $results[] = ['DATE RANGES', 'From', 'To'];
        $results[] = ['', $request->date_from??'--', $request->date_to??'--'];
        $results[] = ['FARMER', 'FARM', 'BARANGAY', 'EXPECTED INCOME', 'INCOME','EXPECTATION DIFFERENCE','PRODUCT','FERTILIZERS','PRODUCTION DATE', 'HARVEST DATE', 'FARMING DURATION'];
        foreach ($transaction as $key => $transaction) {
            $results[] = [$transaction->farmer['name']??'--', $transaction->farm->map['name']??'--', $transaction->farm->barangay??'--', $transaction->details['expected_income']??'--', $transaction->details['income']??'--',$this->expectation_diff($transaction->details['income']??0, $transaction->details['expected_income']??0),$transaction->details['inventories']['seedling']??'--', $this->fertilizers($transaction->details['inventories']['fertilizer']), $transaction->plant_at??'--',$transaction->harvest_at??'--', $this->days_production($transaction->plant_at, $transaction->harvest_at).' days'];
        }

        return (new ChartExport([$results], ['Reports']))->download("Transactions.xlsx");
    }

    public function days_production($production_date, $harvest_date){
        $production_date = Carbon::parse($production_date);
        $harvest_date = Carbon::parse($harvest_date);
        $days_production = $production_date->diffInDays($harvest_date);

        return $days_production;
    }

    public function expectation_diff($income, $expected_income) 
    {
        $result = 0;
        $result = $income - $expected_income;
        return $result;
    }

    public function fertilizers($data) 
    {
        foreach ($data as $key => $value) {
            $array_sample[] = 'Name: '.$value['name'].', Count: '.$value['quantity'];
        }
        return $array_sample;
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
            'amount' => ['required', 'max:255']
        ]);

        Transaction::create([
            'inventory_id' => $request->inventory_id,
            'amount' => $request->amount,
            'type' => $request->type,
            'details' => $request->details
        ]);
        return Redirect::back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}
