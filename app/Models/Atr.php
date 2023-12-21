<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Atr extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function atrfile()
    {
        return $this->hasMany('App\Models\Atrfile','atrfiles_id','id');
    }
    public function clientlogin()
    {
        return $this->hasone('App\Models\Clientlogin','id','responsible_person');
    }
}
