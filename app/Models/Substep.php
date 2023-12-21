<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Substep extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function step()
    {
        return $this->belongsTo('App\Models\Step');
    }
    public function assignment()
    {
        return $this->belongsTo('App\Models\Assignment');
    }
    public function service()
    {
        return $this->belongsTo('App\Models\Service');
    }
    public function substeptask()
    {
        return $this->belongsTo('App\Models\Substeptask');
    }
}
