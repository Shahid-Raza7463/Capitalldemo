<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ifcfolder extends Model
{
    use HasFactory;
    protected $guarded = [];
  
    public function ifc()
    {
        return $this->hasMany('App\Models\Ifc','ifcfolder_id','id');
    }
   
}
