<?php

namespace App\Http\Controllers\Student;


use App\Http\Controllers\Controller;
use App\Models\Student;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\Teacher;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\ApiResponse;
use App\Models\Classroom;
use App\Models\Exam;
use Illuminate\Pagination\Paginator;
use PhpParser\Node\Expr\Eval_;

class StudentController extends Controller
{
    use ApiResponse;
    //
    public function __construct()
    {
        $this->middleware('auth:student', ['except' => ['login']]);//login, register methods won't go through the admin guard

    }
    public function login(Request $request)
    { 
        //validation 
        $validator=Validator::make($request->all(),[
            'email'=>'required',
            'password'=>'required',
        ]);
        if ($validator->fails()) {
            return $this->Response($validator->errors(),'validation errors',406);
            //return response()->json($validator->errors(), 422);
        }
        //return response()->json($request, 422);
        if (! $token = auth('student')->attempt($validator->validated())) {
            return $this->Response('','Unauthorized',401);
            //return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $this->Response(['token'=>$token],'succesfull',200);
        //return response()->json(['token'=>$token], 200);*/
    } 
    public function logout()
    {
        auth()->logout();
        return $this->Response('','Successfully loged out',200);

       // return response()->json(['message' => 'Successfully logged out']);
    }
    public function Home()
    {
        $user=auth()->user();
        return $this->Response($user, 'successful', 200);
    }
    public function classes()
    {
        $user= auth()->user();
        $student=Student::find($user->id);
        $classes=$student->class_room()->paginate(10);
        $classes->makeHidden('pivot');
        return $this->Response($classes,'Successful',200);
    }
    public function class($class_code)
    {
        $user= auth()->user();
        $student=Student::find($user->id);
        $class=Classroom::where('code','=',$class_code)->get();
        if(!$class||$class->count()==0)
        {
            return $this->Response('','Not found',404);
        }
        return $this->Response($class,'Successful',200);
    }

    public function attend($class_code)
    {
        $user= auth()->user();
        $student=Student::find($user->id);
        $class=Classroom::where('code','=',$class_code)->first();
        if(!$class||$class->count()==0)
        {
            return $this->Response('','Not found',404);
        }
         $attend=$student->classattend()->where('Class_id','=',$class->id)->get();
        if($attend->isEmpty())
        {
            return $this->Response(['msg'=>"you don't attend yet"],'Successful',200);
        }
        $attend=$attend->map(function ($attendance) {
            return $attendance->pivot;
        });
        return $this->Response($attend,'Successful',200);
    }
    public function exams($class_code)
    {
        $user= auth()->user();
        $student=Student::find($user->id);
        $class=Classroom::where('code','=',$class_code)->first();
        if(!$class||$class->count()==0)
        {
            return $this->Response('','Not found',404);
        }
        $exams=Exam::with(['student'=>function($q)use ($student)
        {
            $q->where('Student_id','=',$student->id)->select('degree');
        }])->where('Class_id','=',$class->id)->paginate(50);
        
        if ($exams->isEmpty()) {
            return response(['message' => "You don't have exams yet"], 200);
        }
        return $this->Response($exams,'Successful',200);
    }
}
