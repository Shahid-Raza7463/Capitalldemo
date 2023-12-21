<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function getQnaExam()
    {
       return $this->hasOne(ExamAnswer::class,'id','question_id');
    }
   

}
