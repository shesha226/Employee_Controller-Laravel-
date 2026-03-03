<?php

namespace App\Repositories;

use App\Models\Employee;
use App\Repositories\Interface\EmployeeRepositoryInterface;

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
            'data'    => ['employee_id' => $employee->id],
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
            'data'    => null,
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
}