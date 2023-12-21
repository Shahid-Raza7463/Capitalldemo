<?php

namespace App;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
class Admin extends Authenticatable
{
    use Notifiable;

    protected $guard = "admin";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email','status', 'password'
    ];
    
    protected $hidden = [
        'password', 'remember_token',
    ];
}
