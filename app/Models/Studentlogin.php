<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Studentlogin extends Authenticatable
{
  

   // protected $guard = "studentlogin";
   
    protected $fillable = [
        'client_id','email', 'name','password','phoneno'
        ,'status','createdby','updatedby'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
   
}

