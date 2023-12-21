<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function step()
    {
        return $this->hasMany('App\Models\Step');
    }
    public function assignmentbudgeting()
    {
        return $this->hasMany('App\Models\Assignmentbudgeting');
    }
    public function assignmentmapping()
    {
        return $this->hasMany('App\Models\Assignmentmapping');
    }
}
