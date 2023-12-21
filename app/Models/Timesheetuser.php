<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Timesheetuser extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function client()
    {
        return $this->hasMany('App\Models\Client','id','client_id');
    }
    public function assignment()
    {
        return $this->hasMany('App\Models\Assignment','id','assignment_id');
    }
    public function partnerss()
    {
        return $this->hasMany('App\Models\Teammember','id','partner');
    }
}
