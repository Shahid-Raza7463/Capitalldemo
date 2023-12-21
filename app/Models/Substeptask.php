<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Substeptask extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function substep()
    {
        return $this->belongsTo('App\Models\Substep');
    }
}
