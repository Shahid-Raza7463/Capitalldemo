<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Travel extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function travelattachment()
    {
        return $this->hasMany('App\Models\Travelattachment','travel_id','id');
    }
}
