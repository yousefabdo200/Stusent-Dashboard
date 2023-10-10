<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\Teacher;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\ApiResponse;
use App\Models\Classroom;
use App\Models\Exam;
use Illuminate\Pagination\Paginator;

class TeacherController extends Controller
{
    use ApiResponse;
    //
    public function __construct()
    {
        $this->middleware('auth:teacher', ['except' => ['login']]);//login, register methods won't go through the admin guard

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
        if (! $token = auth('teacher')->attempt($validator->validated())) {
            return $this->Response('','Unauthorized',401);
            //return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $this->Response(['token'=>$token],'succesfull',200);
        //return response()->json(['token'=>$token], 200);*/
    } 
    public function Home()
    {
        $user = auth()->user();
        return $this->Response($user, 'successful', 200);
    }
    public function classes()
    {
        $user = auth()->user();
        $class=Classroom::where('Teacher_id','=',$user->id)->paginate(25);
        return $this->Response($class,'successful', 200);
    }
    public function creatclass(Request $request)
    {
        //validation
        $validator=validator::make($request->all(),[
            'name'=>'required|max:250|string',
            'descriprion'=>'required|string',
            'constrains'=>'required|string',
            'code'=>'required|unique:Classroom'
        ]);
        if ($validator->fails()) {
            return $this->Response($validator->errors(),'validation errors',406);
            //return response()->json($validator->errors(), 422);
        }
        //add to database
        $teacher=auth()->user();
        
        $class=Classroom::create(
            [
                'name'=>$request->name,
                'Descriprion'=>$request->descriprion,
                'Constrains'=>$request->constrains,
                'code'=>$request->code,
                'Teacher_id'=>$teacher->id
            ]
            );
            if(!$class)
            {
                return $this->Response('','something in valided',406);
            }
            return $this->Response('','successful',200);
    }
    public function single_class($class_id)
    {
        //$teacher=auth()->user();
        $data=Classroom::where('id','=',$class_id)->first();
        if(!$data)
        {
            return $this->Response('','Not fonund',404);
        }
        return $this->Response($data,'successful',200);
        
    }
    public function class_students($class_id)
    {
        $classroom = Classroom::find($class_id);
        if(!$classroom)
        {
            return $this->Response('','Not fonund',404);
        }
        $students=$classroom->student()->paginate(50);
        return $this->Response($students,'Successful',200);
    }
    public function add_student(Request $request)
    {
        //Validation
        $validator=Validator::make($request->all(),[
            'SSN' => 'required|exists:Student,SSN',
            'class_code' => 'required|exists:classroom,code',
        ]);
        if ($validator->fails()) {
            return $this->Response($validator->errors(),'validation errors',406);
            //return response()->json($validator->errors(), 422);
        }
        //check if student aready in this class
        $student=Student::where('SSN','=',$request->SSN)->first();
        $classroom=Classroom::where('code','=',$request->class_code)->first();
        if (!$student || !$classroom) {
            return $this->Response('', 'Student or classroom not found', 404);
        }
        if ($classroom->student->contains($student)) {
            return $this->Response('', 'Student is already registered in this classroom', 400);
        }
        $classroom->student()->attach($student->id);
        return $this->Response('', 'Student registered successfully', 200);
        //add studendt to this class

    
        //return $this->Response($students,'Successful',200);
    }
    public function create_exam(Request $request)
    {
        //validator
        $validator=Validator::make($request->all(),[
            'name' => 'required|string',
            'number'=>'required|numeric',
            'total_degree'=>'required|numeric',
            'class_code' => 'required|exists:classroom,code',
        ]);
        if($validator->fails())
        {
            return $this->Response($validator->errors(),'validation errors',406);
        }
       
        $classroom=Classroom::where('code','=',$request->class_code)->first();
        //check if there is the same exam or not
        $exam=Exam::where('number','=',$request->number)->where('Class_id','=',$classroom->id)->first();
        if($exam)
        {
            return $this->Response('','Exam number is exist',406);

        }
        
        $exam=Exam::create([
            'name'=>$request->name,
            'total_degree'=>$request->total_degree,
            'number'=>$request->number,
            'Class_id'=>$classroom->id
        ]);
        
        $studentsInClass = $classroom->student()->paginate(50);

        foreach($studentsInClass as $student)
        {
            $exam->student()->attach($student->id);
        }
        return $this->Response($studentsInClass, 'Exam added successfully now you can add students degree', 200);

    }
 public function all_exams(Request $request)
 {
    $validator=Validator::make($request->all(),[
        'class_id' => 'required|numeric|exists:classroom,id',
    ]);
    if($validator->fails())
    {
        return $this->Response($validator->errors(),'validation errors',406);
    }
    $calss=Classroom::find($request->class_id);
    $data=$calss->exam()->get();
    return $this->Response($data, 'successful', 200);

 }
 //singel Exam
 public function get_exam(Request $request)
 {
    //validation 
    $validator=Validator::make($request->all(),[
        'class_code' => 'required|exists:classroom,code',
        'number'=>'required|numeric'
    ]);
    if ($validator->fails()) {
        return $this->Response($validator->errors(),'validation errors',406);
        //return response()->json($validator->errors(), 422);
    }
    //check if class aready in this class
    $classroom=Classroom::where('code','=',$request->class_code)->first();

    $exam=Exam::where('number','=',$request->number)->where('Class_id','=',$classroom->id)->first();
    if(!$exam)
    {
        return $this->Response('','Exam not found',404);

    }
    return $this->Response($exam, 'successful', 200);

 }
 public function student_degrees(Request $request)
 {
    //validtion 
    $validator=Validator::make($request->all(),[
        'class_code' => 'required|exists:classroom,code',
        'number'=>'required|numeric'
    ]);
    if ($validator->fails()) {
        return $this->Response($validator->errors(),'validation errors',406);
        //return response()->json($validator->errors(), 422);
    }
    $classroom=Classroom::where('code','=',$request->class_code)->first();
    $exam=Exam::where('number','=',$request->number)->where('Class_id','=',$classroom->id)->first();
    if(!$exam)
    {
        return $this->Response('','Exam not found',404);

    } 
    $data=$exam->student()->select(['name','SSN','grade','degree'])->get();   

    return $this->Response($data, 'successful', 200);

 }
 public function set_degrees(Request $request)
 {
    //validtion 
    $validator=Validator::make($request->all(),[
        'SSN' => 'required|exists:Student,SSN',
        'exam_id'=>'required|exists:Exam,id',
        'degree'=>'required|numeric'
    ]);
    if ($validator->fails()) {
        return $this->Response($validator->errors(),'validation errors',406);
        //return response()->json($validator->errors(), 422);
    }
   
    $student = Student::where('SSN', '=', $request->SSN)->first();
    //$exam = Exam::find($request->Exam_id);
    if (!$student) {
        return $this->Response('', 'Student not found', 404);
    }
    $student->exam()->updateExistingPivot($request->exam_id,['degree' => $request->degree]);
    return $this->Response('', 'successful', 200);


 }
    public function logout()
    {
        auth()->logout();
        return $this->Response('','Successfully loged out',200);
       // return response()->json(['message' => 'Successfully logged out']);
    }
    
}
