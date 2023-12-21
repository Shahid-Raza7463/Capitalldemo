<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Timesheet extends Model
{
    use HasFactory;
    protected $guarded = [];

	 public function timesheetusers(){

        return $this->hasMany(Timesheetuser::class,'timesheetid','id');
    }
}
