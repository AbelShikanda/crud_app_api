<?php

namespace App\Http\Controllers;

use App\Models\Students;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentsController extends Controller
{
    public function index()
    {
        // Retrieve all students from the database
        $students = Students::all();
        
        // Return the view with the students data
        // return view('students.index', compact('students'));
        if($students) {
        return response()->json([
                'status' => 200,
                'message' => "Students"
            ], 200);
        }else {
            return response()->json([
                'status' => 500,
                'message' => "someting went wrong"
            ], 500);
        }
    }

    public function store(Request $request)
    {
        // Validate incoming request data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email',
            'course' => 'required|string|max:191',
            'phone' => 'required|digits:10',
        ]);

        // If validation fails, return validation errors
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // Create a new student record
        $student = new Students();
        $student->name = $request->input('name');
        $student->email = $request->input('email');
        // Set other fields as needed
        $student->save();

        // Return a success response with the created student record
        return response()->json(['message' => 'Student created successfully', 'student' => $student], 201);
    }

    // public function store(Request $request) {
        
    //     $validator = Validator::make($request->all(), [
    //         'name' => 'required|string|max:191',
    //         'course' => 'required|string|max:191',
    //         'email' => 'required|email|max:191',
    //         'phone' => 'required|digits:10',
    //     ]);

    //     if($validator->fails()) {
    //         return response()->json([
    //             'status' => 422,
    //             'error' => $validator->getMessageBag()
    //         ], 422);
    //     }else {
    //         $student= Students::create([
    //             'name' => $request->name,
    //             'course' => $request->course,
    //             'email' => $request->email,
    //             'phone' => $request->phone,
    //         ]);

    //         if($student) {
    //             return response()->json([
    //                 'status' => 200,
    //                 'message' => "Student created successfully"
    //             ], 200);
    //         }else {
    //             return response()->json([
    //                 'status' => 500,
    //                 'message' => "someting went wrong"
    //             ], 500);
    //         }
    //     }
    // }

    public function show($id)
    {
        try {
            // Retrieve the student from the database based on the provided ID
            $student = Students::findOrFail($id);

            // Return the student data as a JSON response
            return response()->json(['student' => $student], 200);
        } catch (ModelNotFoundException $e) {
            // Handle the case where the student with the provided ID is not found
            return response()->json(['error' => 'Student not found'], 404);
        }
    }

    public function edit($id)
    {
        try {
            // Retrieve the student from the database based on the provided ID
            $student = Students::findOrFail($id);

            // Return the student data along with the view for editing
            return view('students.edit', ['student' => $student]);
        } catch (ModelNotFoundException $e) {
            // Handle the case where the student with the provided ID is not found
            return response()->json(['error' => 'Student not found'], 404);
        }
    }

    public function update(Request $request, $id)
    {
        // Retrieve the student record by ID
        $student = Students::findOrFail($id);

        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'age' => 'required|integer|min:0',
            'grade' => 'required|string|max:255',
            // Add validation rules for other fields as needed
        ]);

        // If validation fails, return validation errors
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // Update the student record with the new data
        $student->update([
            'name' => $request->input('name'),
            'age' => $request->input('age'),
            'grade' => $request->input('grade'),
            // Update other fields as needed
        ]);

        // Return a success response
        return response()->json(['message' => 'Student updated successfully'], 200);
    }

    public function destroy($id)
    {
        // Find the student by ID
        $student = Students::findOrFail($id);

        // Delete the student record
        $student->delete();

        // Return a success response
        return response()->json(['message' => 'Student deleted successfully'], 200);
    }

}
