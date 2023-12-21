<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Step extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function assignment()
    {
        return $this->belongsTo('App\Models\Assignment');
    }
    public function service()
    {
        return $this->belongsTo('App\Models\Service');
    }
    public function group()
    {
        return $this->belongsTo('App\Models\Group');
    }
    public function tab()
    {
        return $this->belongsTo('App\Models\Tab');
    }
}
