<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Vendor extends Authenticatable
{
  

    protected $guard = "vendor";
    protected $guarded = [];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}

