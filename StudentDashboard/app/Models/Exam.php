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


class Exam  extends  Authenticatable implements JWTSubject 
{
    use HasFactory;
    protected $table='Exam';
    protected $fillable=['name','total_degree','Class_id','number','created_at'];
    protected $hidden = ['updated_at','pivot'];
   // Disable 'updated_at' timestamps
    public function class_room()
    {
        return $this->belongsTo(Classroom::class,'Class_id');
    }
    
    public function student()
    {
        return $this->belongsToMany(Student::class,'Student_Exam_degree','Exam_id','Student_id')->withPivot('degree');
    }
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
