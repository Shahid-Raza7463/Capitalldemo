<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Financerequest extends Model
{
    use HasFactory;

    protected $guarded = [];
     
    public function teammember()
    {
        return $this->belongsTo('App\Models\Teammember');
    }
} 
