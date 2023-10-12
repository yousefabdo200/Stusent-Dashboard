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

class Student  extends  Authenticatable implements JWTSubject 
{
    use HasFactory;
    protected $table='Student';
    protected $fillable=['id','name','password','SSN','Email','Pphone','Grade','birth_date','PEmail','created_at','updated_at','Admin_id'];
    protected $hidden=['created_at','updated_at','password'];
       public function admin():BelongsTo  // Admin and student relation 
    {
       return $this->belongsTo(Admin::class,'Admin_id');
    }
     /////////////////////////////JWT Methods ////////////////////////////////////
     public function class_room()
     {
        return $this->belongsToMany(Classroom::class,'Student_Class_registe', 'Student_id', 'Class_id');
     }
     public function Exam()
    {
        return $this->belongsToMany(Exam::class,'Student_Exam_degree','Student_id','Exam_id')->withPivot('degree');
    }
    public function classattend()
    {
        return $this->belongsToMany(Classroom::class,'Student_Classroom_attend','Student_id','Class_id')->withPivot(['created_at','status']);
    }
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
