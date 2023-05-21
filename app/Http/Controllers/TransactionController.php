<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
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
        $transactions = Transaction::where('type', 'plant')->orderBy('id','DESC')->with('farmer')->with('farm')->with('user')->when($request->search != null && $request->search!= '', function ($query) use ($request) {
            $query->whereHas('farmer', function (Builder $query) use ($request) {
                $query->where('name', 'like', "%$request->search%");
            })->orWhereHas('farm', function (Builder $query) use ($request){
                $query->where('map->name', 'like', "%$request->search%");
            });
        })->where('is_inputed', false)->paginate(10); 
        return Inertia::render('Transaction/Index',[
            'transactions' => $transactions,
            'search' => $request->search ?? '',
            'view_filter' => $request->filter_view ?? 'all'
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
