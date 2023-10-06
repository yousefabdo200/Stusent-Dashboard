<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use App\Models\Teacher;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\ApiResponse;
class AdminController extends Controller
{
    //
    use ApiResponse;
    public function __construct()
    {
        $this->middleware('auth:admin', ['except' => ['login', 'register']]);//login, register methods won't go through the admin guard

    }

    // login function
    public function login(Request $request)
    {
        //validation 
        $validator=Validator::make($request->all(),[
            'name'=>'required',
            'password'=>'required',
        ]);
        if ($validator->fails()) {
            return $this->Response($validator->errors(),'validation errors',406);
            //return response()->json($validator->errors(), 422);
        }
        //return response()->json($request, 422);
        if (! $token = auth('admin')->attempt($validator->validated())) {
            return $this->Response('','Unauthorized',401);
            //return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $this->Response(['token'=>$token],'succesfull',200);
        //return response()->json(['token'=>$token], 200);
    } 
    public function Home()
    {
        return $this->Response(auth()->user(),'succesfull',200);
       // return response()->json(auth()->user());
    }
    // add new teacher 
    public function create_teacher(Request $request)
    {
        //Validte Teacher data
        $validation = Validator::make($request->all(),[
            'name'=>'required|max:250|string',
            'password' => 'required|min:6|confirmed:password_confirmation',
            'password_confirmation' => 'required', 
            'SSN'=>'required|Numeric|min:15|unique:Teacher',
            'Email'=>'required|Email|unique:Teacher',
        ]);
        if($validation->fails())
        {
            return $this->Response($validation->errors(),'validation errors',406);
        }
        $admin = auth()->user(); // Retrieve the authenticated admin
        //$admin = auth()->user();
        $teacher=Teacher::create(
            [
                'name'=>$request->get('name'),
                'password'=>Hash::make($request->get('password')),
                'Email'=>$request->get('Email'),
                'SSN'=>$request->get('SSN'),
                'Admin_id'=>$admin->id
            ]
            );
            $token = JWTAuth::fromUser($teacher);
            return $this->Response('','User successfully registered',200);
            /*
            return response()->json([
                'message' => 'User successfully registered',
                'token' => $token,
            ], 200);*/
    } 
    //add new student
    public function create_student(Request $request)
    {
        //Validte Teacher data
        $validation = Validator::make($request->all(),[
            'name'=>'required|max:250|string',
            'password' => 'required|min:6|confirmed:password_confirmation',
            'password_confirmation' => 'required', 
            'SSN'=>'required|Numeric|min:15|unique:Student',
            'Email'=>'required|Email|unique:Student',
            'PEmail'=>'required|Email|unique:Student',
            'Pphone'=>'required|Numeric',
            'Grade'=>'required',
            'birth_date'=>'required|date_format:Y-m-d',

        ]);
        if($validation->fails())
        {
            return $this->Response($validation->errors(),'validation errors',406);
        }
        $admin = auth()->user(); // Retrieve the authenticated admin
        //$admin = auth()->user();
        $student=Student::create(
            [
                'name'=>$request->get('name'),
                'password'=>Hash::make($request->get('password')),
                'Email'=>$request->get('Email'),
                'PEmail'=>$request->get('PEmail'),
                'Pphone'=>$request->get('Pphone'),
                'Grade'=>$request->get('Grade'),
                'SSN'=>$request->get('SSN'),
                'birth_date'=>$request->get('birth_date'),
                'Admin_id'=>$admin->id
            ]
            );
            $token = JWTAuth::fromUser($student);
            return $this->Response('','User successfully registered',200);
            /*
            return response()->json([
                'message' => 'User successfully registered',
                'token' => $token,
            ], 200);*/
    } 

    //view All teacheres
    public function view_teacher()
    {
        $admin = auth()->user(); // Retrieve the authenticated admin
        /*
        $teacher=Admin :: with(['teacher'=>function($query)
        {
            $query->select('id','name');
        }])->find($admin->id);*/
        $data=Teacher::with(['admin'=>function($query)
        {
            $query->select(['id','name']);
        }
        ])->where('Admin_id', $admin->id)->select(['id','name','Email','SSN','Admin_id','created_at','updated_at'])->paginate(50);

        if(!$data)
        {
            return $this->Response('','Not fonund',404);
            /*
            return response()->json(
                [
                    'message'=>'no teachers Added',
                ],
                404
            );*/
        }
        $data->makeHidden('Admin_id');
        return $this->Response($data,'All Teachers',200);
       /* return response()->json([
            'message' => 'All teachers',
            'data'=>$teacher
        ], 200);*/

        
    }
    //view All students  
    public function view_student()
    {
        $admin = auth()->user(); // Retrieve the authenticated admin
        $data=Student::with(['admin'=>function($query)
        {
            $query->select(['id','name']);
        }
        ])->where('Admin_id', $admin->id)->select(['id','name','Email','PEmail','SSN','Pphone','Grade','Admin_id','birth_date','created_at','updated_at'])->paginate(200);

        if(!$data)
        {
            return $this->Response('','Not fonund',404);
            /*
            return response()->json(
                [
                    'message'=>'no Students Added',
                ],
                404
            );*/
        }
        $data->makeHidden('Admin_id');
        return $this->Response($data,'All Students',200);
        /*
        return response()->json([
            'message' => 'All Students',
            'data'=>$student->student
        ], 200);*/

        
    }




// select single student 
  public function select_student($student_id)
    {
        $admin = auth()->user(); // Retrieve the authenticated admin
        $student=Student::where('id', $student_id)
        ->where('Admin_id', $admin->id)->select(['id','name','SSN','Email','pEmail','Pphone','Grade','birth_date'])->get();
        if(!$student||$student->count()==0)
        {
            return $this->Response('','Not fonund',404);
            /*
            return response()->json(
                [
                    'message'=>'no teachers Added',
                ],
                404
            );*/
        }
        return $this->Response($student,'Student data',200);
        /*
        return response()->json([
            'message' => 'student data',
            'data'=>$student
        ], 200);*/
    }
    //select single teacher
    public function select_teacher($teacher_id)
    {
        $admin = auth()->user(); // Retrieve the authenticated admin
        $teacher=Teacher::where('id', $teacher_id)
        ->where('Admin_id', $admin->id)->select(['id','name','SSN','Email'])->get();
        if(!$teacher||$teacher->count()==0)
        {
            return $this->Response('','Not fonund',404);
            /*
            return response()->json(
                [
                    'message'=>'no teachers Added',
                ],
                404
            );*/
        }
        return $this->Response($teacher,'Teacher data',200);

        /*
        return response()->json([
            'message' => 'teacher data',
            'data'=>$teacher
        ], 200);*/
    } 

    public function update_teacher(Request $request , $teacher_id)
    {
        //check if user exsist
        $admin = auth()->user();
        $teacher=Teacher::with('admin')->where('id',$teacher_id)->where('Admin_id',$admin->id)->first();
        if(!$teacher||$teacher->count()==0)
        {
            return $this->Response('','Not fonund',404);
            /*
            return response()->json(
                [
                    'message'=>'no teachers Added',
                ],
                404
            );*/
        }
        //validation 
        $validate=Validator::make($request->all(),
        [
            'name'=>'required|max:250|string',
            'SSN'=>'required|Numeric|min:15||unique:Teacher,SSN,'.$teacher->id,
            'Email'=>'required|Email|unique:Teacher,Email,'.$teacher->id
        ]);
        if($validate->fails())
        {
            return $this->Response($validate->errors(),'validation errors',406);
        }
        $teacher->update($request->all());
        return $this->Response('','teacher Updated Succesfully',200);
        /*
        return response()->json([
            'message' => 'teacher Updated Succesfully',
            'data'=>$teacher
        ], 200);*/
    }


    public function update_student(Request $request , $student_id)
    {
        //check if user exsist
        $admin = auth()->user();
        $student=Student::with('admin')->where('id',$student_id)->where('Admin_id',$admin->id)->first();
        if(!$student||$student->count()==0)
        {
            return $this->Response('','Not fonund',404);
            /*
            return response()->json(
                [
                    'message'=>'no teachers Added',
                ],
                404
            );*/
        }
        //validation 
        $validate=Validator::make($request->all(),
        [
            'name'=>'required|max:250|string',
            'SSN'=>'required|Numeric|min:15|unique:Student,SSN,'.$student->id,
            'Email'=>'required|Email|unique:Student,Email,'.$student->id,
            'PEmail'=>'required|Email|unique:Student,PEmail,'.$student->id,
            'Pphone'=>'required|Numeric|unique:Student,Pphone,'.$student->id,
            'Grade'=>'required',
        ]);
        if($validate->fails())
        {
            return $this->Response($validate->errors(),'validation errors',406);
        }
        $student->update($request->all());
        return $this->Response('','student Updated Succesfully',200);
        /*
        return response()->json([
            'message' => 'student Updated Succesfully',
            'data'=>$student
        ], 200);*/
    }
    //Delete teacher
    public function delete_teacher($teacher_id) 
    {
        $admin = auth()->user();
        $teacher=Teacher::with('admin')->where('id',$teacher_id)->where('Admin_id',$admin->id)->first();
        if(!$teacher||$teacher->count()==0)
        {
            return $this->Response('','Not fonund',404);
            /*
            return response()->json(
                [
                    'message'=>'no teachers Added',
                ],
                404
            );*/
        }
        $teacher->delete();
        return $this->Response('','teacher Deleted Succesfully',200);
        /*
        return response()->json([
            'message' => 'teacher Deleted Succesfully',
            'data'=>[]
        ], 200);
        */
    }

    public function delete_student($student_id)
    {
        $admin = auth()->user();
        $student=Student::with('admin')->where('id',$student_id)->where('Admin_id',$admin->id)->first();
        if(!$student||$student->count()==0)
        {
            return $this->Response('','Not fonund',404);
            /*
            return response()->json(
                [
                    'message'=>'no teachers Added',
                ],
                404
            );*/
        }
        $student->delete();
        return $this->Response('','student Deleted Succesfully',200);
        /*
        return response()->json([
            'message' => 'student Deleted Succesfully',
            'data'=>[]
        ], 200);*/
        
    }


    public function logout()
    {
        auth()->logout();
        return $this->Response('','Successfully loged out',200);
       // return response()->json(['message' => 'Successfully logged out']);
    }
    
   
    
}  
