<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Teacher extends  Authenticatable implements JWTSubject 
{
    use HasFactory;
    protected $table='Teacher';

    protected $fillable=['id','name','password','SSN','Email','created_at','updated_at','Admin_id'];
    protected $hidden=['password'];
   
     public function admin():BelongsTo // Admin and teacher relation 
     {
        return $this->belongsTo(Admin::class,'Admin_id');
     }
     public function classroom():HasMany // Teacher and classroom relation 
     {
        return $this->hasMany(Classroom::class,'Teacher_id');
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
