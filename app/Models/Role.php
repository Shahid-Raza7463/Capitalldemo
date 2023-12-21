<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $guarded = [];
   
    public function permission()
    {
        return $this->hasMany('App\Models\Permission');
    }  
    public function teammember()
    {
        return $this->hasMany('App\Models\Teammember');
    }  
    public function user()
    {
        return $this->hasMany('App\Models\User');
    } 
}
