<?php

namespace App\Repositories;

use App\Models\Employee;
use App\Repositories\Interface\EmployeeRepositoryInterface;

class EmployeeRepository implements EmployeeRepositoryInterface
{
    public function createEmployee(array $data)
    {
        $name = $data['name']?? null;
        $email = $data['email'] ?? null;
        $phone = $data['phone'] ?? null;
        $age = $data['age'] ?? null;
        $created_by = isset($data['created_by']) ? (int) $data['created_by'] : 0;


    if (!$name || !$email || !$phone || $age <= 0 || $created_by <= 0) {
            return[
                'success' => false,
            'message' => 'Name, Email, Phone, Age and Created By are required.',
            'data'    => null,
            ];
        }

        $employee = Employee::where('email' , $email)
        ->where('status', 'active')
         ->first();

         if($employee){
            return[
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
        'created_at' => now(),
        'updated_at' => now(),
         ]);
          return [
        'success' => true,
        'message' => 'Employee created successfully.',
        'data'    => [
            'employee_id' => $employee->id,
        ],
    ];
    }
}