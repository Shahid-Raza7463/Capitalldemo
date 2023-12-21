<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamAnswer extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function questionss()
    {
        return $this->hasOne(Question::class,'id','question_id');
    }
    public function answerss()
    {
        return $this->hasOne(Answer::class,'id','answer_id');
    }
   

}
