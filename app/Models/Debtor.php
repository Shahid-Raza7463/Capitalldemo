<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Debtor extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function debtorconfirm()
    {
        return $this->hasOne('App\Models\Debtorconfirmation','debtor_id','id');
    }
}
