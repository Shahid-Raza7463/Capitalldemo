<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recruitmentform extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function clientdocument()
    {
        return $this->hasMany('App\Models\Clientdocument');
    }
}
