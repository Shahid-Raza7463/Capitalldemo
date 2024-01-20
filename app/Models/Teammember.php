<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teammember extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function getprofilePicAttribute($value)
    {
        if ($value) {
            return url('backEnd/image/teammember/profilepic/' . $value);
        } else {
            return env('APP_CMS_ALL').'';
        }
    }
    public function getpanUploadAttribute($value)
    {
        if ($value) {
            return url('backEnd/image/teammember/panupload/' . $value);
        } else {
            return env('APP_CMS_ALL').'';
        }
    }
    public function getaddressUploadAttribute($value)
    {
        if ($value) {
            return url('backEnd/image/teammember/addressupload/' . $value);
        } else {
           return env('APP_CMS_ALL').'';
        }
    }
    public function title()
    {
        return $this->belongsTo('App\Models\Title');
    }
    public function role()
    {
        return $this->belongsTo('App\Models\Role');
    }
    public function user()
    {
        return $this->hasMany('App\Models\User');
    }
     public function asset()
    {
        return $this->hasMany('App\Models\Asset');
    }
}
