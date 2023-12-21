<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    

       protected $fillable = [
        'client_code','client_name','kind_attention',  'emailid','c_address','c_state'
        ,'mobileno','associatedfrom','leadpartner','panno','legalstatus','tanno','gstno','dateofincorporation','otherpartner','clientdesignation','name'
       , 'engagementpartner','clientdob','createdbyadmin_id','updatedbyadmin_id','status'
    ];

    public function gettanUploadAttribute($value)
    {
        if ($value) {
            return url('backEnd/image/client/tanupload/' . $value);
        } else {
            return env('APP_CMS_ALL').'img/banner/default.png';
        }
    }
    public function getpanUploadAttribute($value)
    {
        if ($value) {
            return url('backEnd/image/client/panupload/' . $value);
        } else {
            return env('APP_CMS_ALL').'img/banner/default.png';
        }
    }
    public function getgstUploadAttribute($value)
    {
        if ($value) {
            return url('backEnd/image/client/gstupload/' . $value);
        } else {
            return env('APP_CMS_ALL').'img/banner/default.png';
        }
    }
    public function assignmentbudgeting()
    {
        return $this->hasMany('App\Models\Assignmentbudgeting');
    }
    public function assignmentmapping()
    {
        return $this->hasMany('App\Models\Assignmentmapping');
    }
  
     public function clientdocument()
    {
        return $this->hasMany('App\Models\Clientdocument');
    }
	 public function scopeactiveClient($query)
    {
        return $query->whereStatus('1');
    }
    // protected $fillable = [
    //     'client_name','kind_attention', 'emailid','c_address','scopeofwork','c_state','mobileno',
    //     'associatedfrom', 'leadpartner','panno','legalstatus','tanno','tanupload','gstno',
    //     'gstupload','dateofincorporation','anotherpartner','companygroup','engagementpartner','clientdob'
    // ];
}
