<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignmentteammapping extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function assignmentmapping()
    {
        return $this->hasMany('App\Models\Assignmentmapping');
    }
}
