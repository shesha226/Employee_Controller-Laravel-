<?php

namespace App\Repositories;

use App\Models\Employee;
use App\Models\Attendance;
use App\Models\Salary;
use App\Models\Leave;
use App\Repositories\Interfaces\EmployeeRepositoryInterface; 

class EmployeeRepository implements EmployeeRepositoryInterface
{
    // ✅ CREATE
    public function createEmployee(array $data) 
    {
        $name = $data['name'] ?? null;
        $email = $data['email'] ?? null;
        $phone = $data['phone'] ?? null;
        $age = isset($data['age']) ? (int)$data['age'] : 0;
        $created_by = isset($data['created_by']) ? (int)$data['created_by'] : 0;

        if (!$name || !$email || !$phone || $age <= 0 || $created_by <= 0) {
            return [
                'success' => false,
                'message' => 'Name, Email, Phone, Age and Created By are required.',
                'data'    => null,
            ];
        }

        $employee = Employee::where('email', $email)
            ->where('status', 'active')
            ->first();

        if ($employee) {
            return [
                'success' => false,
                'message' => 'Employee email already exists.',
                'data'    => null,
            ];
        }

        $employee = Employee::create([
            'name'       => $name,
            'email'      => $email,
            'address'    => $data['address'] ?? null,
            'phone'      => $phone,
            'age'        => $age,
            'gender'     => $data['gender'] ?? null,
            'dob'        => $data['dob'] ?? null,
            'join_date'  => $data['join_date'] ?? now(),
            'department' => $data['department'] ?? null,
            'position'   => $data['position'] ?? null,
            'salary'     => $data['salary'] ?? null,
            'status'     => 'active',
        ]);

        return [
            'success' => true,
            'message' => 'Employee created successfully.',
            'data'    => [ $employee],
        ];
    }

    // ✅ GET ALL
    public function getAllEmployees()
    {
        $employees = Employee::where('status', 'active')->get();

        return [
            'success' => true,
            'message' => 'Employee list fetched successfully.',
            'data'    => $employees,
        ];
    }

    // ✅ GET BY ID
    public function getEmployeeById($id)
    {
        $employee = Employee::where('id', $id)
            ->where('status', 'active')
            ->first();

        if (!$employee) {
            return [
                'success' => false,
                'message' => 'Employee not found.',
                'data'    => null,
            ];
        }

        return [
            'success' => true,
            'message' => 'Employee fetched successfully.',
            'data'    => $employee,
        ];
    }

    // ✅ UPDATE
    public function updateEmployee($id, array $data)
    {
        $employee = Employee::where('id', $id)
            ->where('status', 'active')
            ->first();

        if (!$employee) {
            return [
                'success' => false,
                'message' => 'Employee not found.',
                'data'    => null,
            ];
        }

        $employee->update($data);

        return [
            'success' => true,
            'message' => 'Employee updated successfully.',
            'data'    => $employee,
        ];
    }

    // ✅ DELETE (Soft Delete Style)
    public function deleteEmployee($id)
    {
        $employee = Employee::where('id', $id)
            ->where('status', 'active')
            ->first();

        if (!$employee) {
            return [
                'success' => false,
                'message' => 'Employee not found.',
                'data'    => null,
            ];
        }

        $employee->update(['status' => 'inactive']);

        return [
            'success' => true,
            'message' => 'Employee deleted successfully.',
            'data'    => null,
        ];
    }

    public function createSalary(array $data)
    {
        $employee_id = $data['employee_id'] ?? null;
        $basic_salary = $data['basic_salary'] ?? null;
        $bonus        = $data['bonus'] ?? 0;
        $deductions   = $data['deductions'] ?? 0;
        $pay_date     = $data['pay_date'] ?? now();

        if(!$employee_id || !$basic_salary || !$bonus || !$deductions ){
            return [
            'success' => false,
            'message' => 'All field Are required.',
            'data'    => null,
        ];
        }

        $employee= Employee::where('id', $employee_id)
        ->where('status' , 'active')
        ->first();

        if (!$employee) {
        return [
            'success' => false,
            'message' => 'Employee not found for salary.',
            'data'    => null,
        ];
    }


    if(!$basic_salary === null || !is_numeric($basic_salary) || $basic_salary<0){
        return[
            'success' => false,
            'message' => 'Basic salary is required and must be a positive number.',
            'data'    => null,
        ];
    }

    $salary = Salary::create([
        'employee_id' => $employee_id,
        'basic_salary'=> $basic_salary,
        'bonus'       => $bonus,
        'deductions'  => $deductions,
        'pay_date'    => $pay_date,
    ]);

  return [
        'success' => true,
        'message' => 'Salary created successfully.',
        'data'    => [$salary],
    ];
}

public function getAllSalaries()
    {
        $salaries = Salary::all(); 

        return [
            'success' => true,
            'message' => 'Salary list fetched successfully.',
            'data'    => $salaries,
        ];
    }
public function getSalaryById($id){
    $salary = Salary::where('id', $id)->first();

    if(!$salary){
        return [
            'success' => false,
            'message' => 'Salary not found.',
            'data'    => null,
        ];
    }

    return [
        'success' => true,
        'message' => 'Salary fetched successfully.',
        'data'    => $salary,
    ];
    
}

public function updateSalary($id, array $data){
    $salary = Salary::where('id', $id)
   
    ->first();

    if(!$salary){
        return [
            'success' => false,
            'message' => 'Salary not found.',
            'data'    => null,
        ];
    }

    $salary->update($data);

    return [
        'success' => true,
        'message' => 'Salary updated successfully.',
        'data'    => $salary,
    ];
    
}

public function deleteSalary($id){
    $salary = Salary::where('id', $id)
    
    ->first();

    if(!$salary){
        return [
            'success' => false,
            'message' => 'Salary not found.',
            'data'    => $salary,
        ];
    }

    $salary->update(['status' => 'inactive']);

    return [
        'success' => true,
        'message' => 'Salary deleted successfully.',
        'data'    => $salary,
    ];
    
}

public function createAttendance(array $data){

    $employee_id = $data['employee_id'] ?? null;
    $check_in = $data['check_in'] ?? null;
    $check_out = $data['check_out'] ?? null;
    $date = $data['date'] ?? null;

    if(!$employee_id || !$check_in || !$check_out || !$date){
        return [
            'success' => false,
            'message' => 'All field Are required.',
            'data'    => null,
        ];
    }

    $attendance = Attendance::create([
        'employee_id' => $employee_id,
        'check_in'    => $check_in,
        'check_out'   => $check_out,
        'date'        => $date,
    ]);

    return [
        'success' => true,
        'message' => 'Attendance created successfully.',
        'data'    => [$attendance],
    ];    
}

public function getAllAttendances(){

    $attendances = Attendance::all();

    return [
        'success' => true,
        'message' => 'Attendance list fetched successfully.',
        'data'    => $attendances,
    ];
    
}

public function getAttendanceById($id){
    $attendance = Attendance::where('id', $id)->first();

    if(!$attendance){
        return [
            'success' => false,
            'message' => 'Attendance not found.',
            'data'    => null,
        ];
    }

    return [
        'success' => true,
        'message' => 'Attendance fetched successfully.',
        'data'    => $attendance,
    ];
    
}

public function updateAttendance($id, array $data){

    $attendance = Attendance::where('id', $id)->first();

    if(!$attendance){
        return [
            'success' => false,
            'message' => 'Attendance not found.',
            'data'    => null,
        ];
    }

    $attendance->update($data);

    return [
        'success' => true,
        'message' => 'Attendance updated successfully.',
        'data'    => $attendance,
    ];
    
}

public function deleteAttendance($id){

    $attendance = Attendance::where('id', $id)->first();

    if(!$attendance){
        return [
            'success' => false,
            'message' => 'Attendance not found.',
            'data'    => null,
        ];
    }

    $attendance->update(['status' => 'inactive']);

    return [
        'success' => true,
        'message' => 'Attendance deleted successfully.',
        'data'    => $attendance,
    ];
    
}

public function ApplyLeave(array $data){
    
    $employee_id = $data['employee_id'] ?? null;
    $leave_date = $data['leave_date'] ?? null;
    $leave_type = $data['leave_type'] ?? null;
    $status = $data['status'] ?? 'pending';

    if(!$employee_id || !$leave_date || !$leave_type){
        return [
            'success' => false,
            'message' => 'All field Are required.',
            'data'    => null,
        ];
    }

    $leave = Leave::create([
        'employee_id' => $employee_id,
        'leave_date' => $leave_date,
        'leave_type' => $leave_type,
        'status' => $status,
    ]);

    return [
        'success' => true,
        'message' => 'Leave applied successfully.',
        'data'    => [$leave],
    ];    
}

public function getAllLeaves(){

    $leaves = Leave::all();

    return [
        'success' => true,
        'message' => 'Leave list fetched successfully.',
        'data'    => $leaves,
    ];
    
}

public function getLeaveById($id){
    $leave = Leave::where('id', $id)->first();

    if(!$leave){
        return [
            'success' => false,
            'message' => 'Leave not found.',
            'data'    => null,
        ];
    }

    return [
        'success' => true,
        'message' => 'Leave fetched successfully.',
        'data'    => $leave,
    ];
    
}

public function updateLeave($id, array $data){

    $leave = Leave::where('id', $id)->first();

    if(!$leave){
        return [
            'success' => false,
            'message' => 'Leave not found.',
            'data'    => null,
        ];
    }

    $leave->update($data);

    return [
        'success' => true,
        'message' => 'Leave updated successfully.',
        'data'    => $leave,
    ];
    
}

public function deleteLeave($id){

    $leave = Leave::where('id', $id)->first();

    if(!$leave){
        return [
            'success' => false,
            'message' => 'Leave not found.',
            'data'    => null,
        ];
    }

    $leave->update(['status' => 'inactive']);

    return [
        'success' => true,
        'message' => 'Leave deleted successfully.',
        'data'    => $leave,
    ];
    
}

}



