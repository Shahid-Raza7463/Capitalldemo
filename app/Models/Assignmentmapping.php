<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignmentmapping extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function assignmentteammapping()
    {
        return $this->hasMany('App\Models\Assignmentteammapping');
    }
    public function assignment()
    {
        return $this->belongsTo('App\Models\Assignment');
    }
    public function client()
    {
        return $this->belongsTo('App\Models\Client');
    }
}
