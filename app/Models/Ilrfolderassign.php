<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ilrfolderassign extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function clientlogin()
    {
        return $this->belongsTo('App\Models\Clientlogin','clientlogin_id','id');
    }
    public function ilr()
    {
        return $this->hasMany('App\Models\Informationresource','ilrfolder_id','ilrfolder_id');
    }
    public function ilrsubfolder()
    {
        return $this->hasMany('App\Models\Ilrfolder','parent_id','ilrfolder_id');
    }
}
