<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get Employee List
        $employees = Employee::simplePaginate(6);
        // dd($employees);
        return view('employee', [
            'employees' => $employees
        ]);
    }
    /**
     * Return Employee List API
     * 
     * @return JSON $employees
     */
    public function get_employees()
    {
        $employees = Employee::get();
        return response()->json([
            'message'   =>  'Employee List',
            'status'    =>  'success',
            'employees'   =>  $employees
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'position' => 'required',
            'salary' => 'required|numeric',
            'joined_date' => 'required|date',
            'image' => 'mimetypes:image/jpeg,image/png,image/jpg,image/gif,image/webp|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->route('employee.create')
                ->with('error', 'Validation failed')
                ->withErrors($validator)
                ->withInput();
        }

        $newEmployee = new Employee;
        $newEmployee->first_name = $request->first_name;
        $newEmployee->last_name = $request->last_name;
        $newEmployee->email = $request->email;
        $newEmployee->position = $request->position;
        $newEmployee->salary = $request->salary;
        $newEmployee->joined_date = $request->joined_date;

        //Handle image upload and save the image path
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->storeAs('public/images', $request->file('image')->getClientOriginalName());
            $newEmployee->image = str_replace('public/', 'storage/', $imagePath);
        }

        $newEmployee->save();
        return redirect('/employee')->with('success', 'Employee added successfully');
    }
    /**
     * Create Cookie API
     */
    public function create_employee(Request $request)
    {
        $newEmployee = new Employee;
        $newEmployee->first_name = $request->first_name;
        $newEmployee->last_name = $request->last_name;
        $newEmployee->email = $request->email;
        $newEmployee->position = $request->position;
        $newEmployee->salary = $request->salary;
        $newEmployee->joined_date = $request->joined_date;

        //Handle image upload and save the image path
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->storeAs('public/images', $request->file('image')->getClientOriginalName());
            $newEmployee->image = str_replace('public/', 'storage/', $imagePath);
        }

        $newEmployee->save();
        return response()->json([
            'message'   =>  'Employee Created',
            'status'    =>  'success',
            'employee'   =>  $newEmployee
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        return view('edit', compact('employee'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employee $employee)
    {


        $data = $request->validate([
            'image' => 'mimetypes:image/jpeg,image/png,image/jpg,image/gif,image/webp|max:2048',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'position' => 'required',
            'salary' => 'required|numeric',
            'joined_date' => 'required|date',

        ]);

        // Parse the joined_date to 'Y-m-d' format
        $employee->joined_date = \Carbon\Carbon::parse($request->input('joined_date'));

        // Handle image upload and update the image path
        if ($request->hasFile('image')) {
            // Delete the old image (if it exists)
            if ($employee->image) {
                Storage::delete(str_replace('storage/', 'public/', $employee->image));
            }

            $imagePath = $request->file('image')->storeAs('public/images', $request->file('image')->getClientOriginalName());
            $employee->image = str_replace('public/', 'storage/', $imagePath);
        }

        // Update the employee's data using the update method
        $employee->update($data);

        return redirect('/employee')->with('success', 'Employee updated successfully');
    }

    //API Update Function
    public function update_employee(Request $request, Employee $employee)
    {
        // Validate and update the employee's information
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'position' => 'required',
            'salary' => 'required|numeric',
            'joined_date' => 'required|date',
        ]);
        // Parse the joined_date to 'Y-m-d' format
        $employee->joined_date = \Carbon\Carbon::parse($request->input('joined_date'));

        // Update the employee's data using the update method
        $employee->update($request->all());

        // Return a response indicating success
        return response()->json([
            'message' => 'Employee information updated successfully',
            'employee' => $employee,
        ]);
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect('/employee')->with('success', 'Employee deleted successfully');
    }

    public function delete_employee(Request $request)
    {
        $id = $request->id;

        $employee = Employee::find($id);

        if (!$employee) {
            return response()->json(['message' => 'Employee not found.'], 404);
        }

        $employee->delete();

        return response()->json([
            'message' => 'Employee deleted successfully',
            'deletedID' => $id
        ], 200);
    }
}
