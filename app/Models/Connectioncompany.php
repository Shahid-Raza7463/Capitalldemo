<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Connectioncompany extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function connection()
    {
        return $this->belongsTo('App\Models\Connection');
    }
}
