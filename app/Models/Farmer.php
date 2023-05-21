<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Farmer extends Model
{
    use HasFactory, SoftDeletes;
    protected $casts = [
        'details' => 'json', 
    ];
    protected $guarded = [];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    // public function farm(){
    //     return $this->belongsTo(Farm::class);
    // }

    public function parcels(){
        return $this->hasMany(Farm::class);
    }
}
