<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ilrfolder extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function ilr()
    {
        return $this->hasMany('App\Models\Informationresource','ilrfolder_id','id');
    }
	public function ilrsubfolder()
    {
        return $this->hasMany('App\Models\Ilrfolder','parent_id','id');
    }
}
