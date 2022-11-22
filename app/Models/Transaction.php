<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $guarded = [];
    
    public function farmer(){
        return $this->belongsTo(Farmer::class);
    }

    public function farm(){
        return $this->belongsTo(Farm::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
