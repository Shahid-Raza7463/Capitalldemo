<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Timesheetusers extends Model
{
    use HasFactory;
    protected $guarded = [];
    
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }
    public function partner()
    {
        return $this->belongsTo(Teammember::class);
    }
    public function createdBy()
    {
        return $this->belongsTo(Teammember::class);
    }





}

