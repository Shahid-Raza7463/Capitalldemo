<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Connection extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function connectioncompany()
    {
        return $this->hasMany('App\Models\Connectioncompany');
    }
}
