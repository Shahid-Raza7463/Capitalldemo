<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $guarded = [];
     
    public function teammember()
    {
        return $this->belongsTo('App\Models\Teammember');
    }
    public function getAttachmentAttribute($value)
    {
        if ($value) {
            return url('backEnd/image/profile/' . $value);
        } else {
              return url('backEnd/img/active.png' . $value);
        }
    }
} 
