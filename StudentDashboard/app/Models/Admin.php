<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends  Authenticatable implements JWTSubject 
{
    use HasFactory;
    public $table='Admin';
    protected $fillable = [
        'name',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];
    public $timestamps=false;
   
    public function teacher():HasMany  // Admin and teacher relation 
    {
        return $this->hasMany(Teacher::class,'Admin_id');
    } 

    public function student():HasMany  // Admin and Student relation 
    {
        return $this->hasMany(Student::class,'Admin_id');
    }

    /////////////////////////////JWT Methods ////////////////////////////////////
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
    //////////////////////////////////////////////////////////////////
}
