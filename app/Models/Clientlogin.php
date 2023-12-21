<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Clientlogin extends Authenticatable
{
  

    protected $guard = "clientlogin";
   
    protected $fillable = [
        'client_id','limitedaccess','email',  'name','password','phoneno'
        ,'status','permission','createdby','updatedby','twofactorauthentication'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
    public function mis()
    {
        return $this->hasMany('App\Models\Mis','createdby','id');
    }
}

