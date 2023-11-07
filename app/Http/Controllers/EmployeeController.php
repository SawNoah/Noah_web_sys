<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get Employee List
        $employees = Employee::get();
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
        $newEmployee = new Employee;
        $newEmployee->first_name = $request->first_name;
        $newEmployee->last_name = $request->last_name;
        $newEmployee->email = $request->email;
        $newEmployee->position = $request->position;
        $newEmployee->salary = $request->salary;
        $newEmployee->joined_date = $request->joined_date;
        $newEmployee->save();
        return redirect('/employee');
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
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'position' => 'required',
            'salary' => 'required|numeric',
            'joined_date' => 'required|date',
        ]);

        $employee->joined_date = \Carbon\Carbon::parse($request->input('joined_date'));
        $employee->update($data);

        return redirect('/employee')->with('success', 'Employee updated successfully');
    }

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

        // Update the employee's data
        $employee->update_employee($request->all());

        // Return a response indicating success
        return response()->json([
            'message' => 'Employee information updated successfully',
            'employee' => $employee,
        ]);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $id)
    {
        $id->delete();
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
