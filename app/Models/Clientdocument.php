<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clientdocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'document_name','filess','type',  'emailid','client_id','created_by','client_name'
        ,'updated_by'
    ];
    public function getaddressUploadAttribute($value)
    {
        if ($value) {
            return url('backEnd/image/client/document/' . $value);
        } else {
            return env('APP_CMS_ALL').'img/banner/default.png';
        }
    }
     public function client()
    {
        return $this->belongsTo('App\Models\Client');
    }
}
