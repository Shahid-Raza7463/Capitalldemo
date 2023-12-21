<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Financialstatementclassification extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function subfinancialclassfication()
    {
        return $this->hasMany('App\Models\Subfinancialclassfication','id','financialstatemantclassfication_id');
    }
}
