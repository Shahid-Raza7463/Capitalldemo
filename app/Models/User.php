<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'teammember_id','status',
        'email','role_id',
       'password','two_factor_code','two_factor_expires_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
		   protected $dates = [
        'updated_at',
        'created_at',
        'email_verified_at',
        'two_factor_expires_at',
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];
  public function resetTwoFactorCode()
{
    $this->timestamps = false;
    $this->two_factor_code = null;
    $this->two_factor_expires_at = null;
    $this->save();
}
    public function generateTwoFactorCode()
    {
        $this->timestamps = false;
        $this->two_factor_code = rand(100000, 999999);
        $this->two_factor_expires_at = now()->addMinutes(5);
        $this->save();
    }
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function teammember()
    {
        return $this->belongsTo('App\Models\Teammember');
    }
    public function role()
    {
        return $this->belongsTo('App\Models\Role');
    }
}
