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


class Classroom extends  Authenticatable implements JWTSubject 
{
    use HasFactory;
    public $table='classroom';
    protected $fillable = [
        'name',
        'Descriprion',
        'Constrains',
        'created_at',
        'code',
        'Teacher_id'
    ];
    public function student()
    {
       return $this->belongsToMany(Student::class,'Student_Class_registe','Class_id','Student_id');
    }
    public function exam()
    {
        return $this->hasMany(Exam::class,'Class_id');
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
