<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mis extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function misphoto()
    {
        return $this->hasMany('App\Models\Misphoto','mis_id','id');
    }
    public function clientlogin()
    {
        return $this->belongsTo('App\Models\Clientlogin','createdby','id');
    }
}
