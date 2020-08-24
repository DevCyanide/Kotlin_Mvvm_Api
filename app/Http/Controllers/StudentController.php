<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Students as StudentModel;
use App\Http\Requests;
use App\Http\Resources\Students as StudentResource;
use Validator;
use DB;


class StudentController extends Controller
{
    public function index()
    {
        $student = StudentModel::All();
        return StudentResource::collection($student);
    }
    public function store(Request $request)
    {
        $student = $request->isMethod('put') ? StudentModel::findOrFail($request->id) : new StudentModel;
        $student->id = $request->input('id');
        $student->student_num = $request->input('student_num');
        $student->firstname = $request->input('firstname');
        $student->lastname = $request->input('lastname');
        $student->password = $request->input('password');
        if($student->save()){
            return new StudentResource($student);
        }
    }

    public function show($id)
    {
    
        $student = StudentModel::find($id);
        if(is_null($student)){
            return response()->json(["message"=>"Record not found"],404);
        }
        return new StudentResource($student);
    }
    public function destroy($id)
    {
        $student = StudentModel::findOrFail($id);
        if($student->delete()){
        return new StudentResource($student);
        }
    }
        // Submit Login
        function submit_login(Request $request){

            if(empty($request->student_num) || empty($request->password)){
                 return response()->json(["message" =>"Empty fields",404]);
            }
        
         $request->validate([
                'student_num'=>'required',
                'password'=>'required'
            ]);
            $studentCount=StudentModel::where(['student_num'=>$request->student_num,'password'=>$request->password])->count();
            if($studentCount>0){
                $studentData=DB::table('students')->where(['student_num'=>$request->student_num,'password'=>$request->password])->get();
                return response("Login Success",200);
            }else{
                return response("Invalid Username/Password",404);
            }
        }
        //Register
        function submit_register(Request $request){
            $rules = [
                'student_num'=>'required',
                'firstname'=>'required',
                'lastname'=>'required',
                'password'=>'required'
            ];
            $validator = Validator::make($request->all(),$rules);
            if($validator->fails()){
            return response()->json(["message" => $validator->errors()],400);
            }else{
                $student = new StudentModel;
                $student->student_num=$request->student_num;
                $student->firstname=$request->firstname;
                $student->lastname=$request->lastname;
                $student->password=$request->password;
                $student->save();
                return response()->json($student,200);
            }
        }
}
