<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Replyticket extends Model
{
    use HasFactory;
        protected $fillable = [
        'ticketid','reply','attachment',  'createdby'
    ];


}
