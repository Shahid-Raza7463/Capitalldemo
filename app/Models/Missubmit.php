<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Missubmit extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function misphoto()
    {
        return $this->hasMany('App\Models\Misphoto','missubmit_id','id');
    }
    public function clientlogin()
    {
        return $this->belongsTo('App\Models\Clientlogin','clientloginid','id');
    }
    public function teammemberlogin()
    {
        return $this->belongsTo('App\Models\Teammember','createdby','id');
    }
}
