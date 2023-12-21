<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidateonboarding extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function candidateonboardingpayslip()
    {
        return $this->hasMany('App\Models\Candidateonboardingpayslip');
    }
    public function candidateonboardingresidence()
    {
        return $this->hasMany('App\Models\Candidateonboardingresidence');
    }
}
