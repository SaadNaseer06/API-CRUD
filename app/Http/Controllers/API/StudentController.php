<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::all();
        if ($students->count() > 0) {
            $data = [
                'status' => 200,
                'students' => $students,
            ];
        } else {
            $data = [
                'status' => 404,
                'message' => 'No records found',
            ];
        }

        return response()->json($data);
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'course' => 'required',
            'email' => 'required',
            'phone' => 'required',

        ]);

        if ($validator->fails()) {
            $data = [
                'status' => 422,
                'errors' => $validator->messages(),
            ];
        } else {
            $students = new Student;
            $students->name = $request->name;
            $students->course = $request->course;
            $students->email = $request->email;
            $students->phone = $request->phone;
            $students->save();
            $data = [
                'status' => 200,
                'message' => 'Students Created Successfully',
            ];
        }
        return response()->json($data);

    }

    public function show($id)
    {
        $student = Student::find($id);
        if ($student) {
            $data = [
                'status' => 200,
                'student' => $student,
            ];
        } else {
            $data = [
                'status' => 404,
                'message' => 'No such user found',
            ];
        }
        return response()->json($data);
    }

    public function edit($id)
    {
        $student = Student::find($id);
        if ($student) {
            $data = [
                'status' => 200,
                'student' => $student,
            ];
        } else {
            $data = [
                'status' => 404,
                'message' => 'No such user found',
            ];
        }
        return response()->json($data);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'course' => 'required',
            'email' => 'required',
            'phone' => 'required',

        ]);

        if ($validator->fails()) {
            $data = [
                'status' => 422,
                'errors' => $validator->messages(),
            ];
        } else {
            $students = Student::find($id);

            if ($students) {
                $students->name = $request->name;
                $students->course = $request->course;
                $students->email = $request->email;
                $students->phone = $request->phone;
                $students->update();
                $data = [
                    'status' => 200,
                    'message' => 'Student Updated Successfully',
                ];
            } else {
                $data = [
                    'status' => '404',
                    'message' => 'No Such Student Found',
                ];
            }
        }
        return response()->json($data);
    }
    public function delete($id)
    {
        $student = Student::find($id);

        if ($student) {
            $student->delete();
            $data = [
                'status' => 200,
                'message' => 'Record Deleted Successfully',
            ];
        } else {
            $data = [
                'status' => 404,
                'message' => 'No user found',
            ];
        }

        return response()->json($data);
    }

}
