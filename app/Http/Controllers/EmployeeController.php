<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Repositories\Interfaces\EmployeeRepositoryInterface;

class EmployeeController extends Controller
{
    protected $employeeRepository;

    public function __construct(EmployeeRepositoryInterface $employeeRepository)
    {
        $this->employeeRepository = $employeeRepository;
    }

    // ✅ CREATE EMPLOYEE
    public function createEmployee(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name'       => 'required|string',
                'email'      => 'required|email',
                'phone'      => 'required|string',
                'age'        => 'required|integer|min:18',
                'created_by' => 'required|integer|min:1',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => "Validation failed.",
                    'output'  => $validator->errors()->first(),
                ], 422); // Validation error code
            }

            $data = $request->all();
            $out_data = $this->employeeRepository->createEmployee($data);

            return response()->json([
                'success' => $out_data['success'],
                'message' => $out_data['message'],
                'output'  => $out_data['data'],
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong. ' . $e->getMessage(),
                'output'  => null,
            ], 500);
        }
    }

    // ✅ GET ALL EMPLOYEES
    public function getAllEmployees()
    {
        $response = $this->employeeRepository->getAllEmployees();
        return response()->json([
            'success' => $response['success'],
            'message' => $response['message'],
            'output'  => $response['data'],
        ], 200);
    }

    // ✅ GET EMPLOYEE BY ID
    public function getEmployeeById($id)
    {
        $response = $this->employeeRepository->getEmployeeById($id);
        return response()->json([
            'success' => $response['success'],
            'message' => $response['message'],
            'output'  => $response['data'],
        ], 200);
    }

    // ✅ UPDATE EMPLOYEE
    public function updateEmployee(Request $request, $id)
    {
        try {
            $data = $request->all();
            $response = $this->employeeRepository->updateEmployee($id, $data);
        } catch (\Exception $e) {
            $response = [
                'success' => false,
                'message' => 'Something went wrong. ' . $e->getMessage(),
                'data'    => null,
            ];
        }

        return response()->json([
            'success' => $response['success'],
            'message' => $response['message'],
            'output'  => $response['data'] ?? null,
        ], 200);
    }

    // ✅ DELETE EMPLOYEE
    public function deleteEmployee($id)
    {
        try {
            $response = $this->employeeRepository->deleteEmployee($id);
        } catch (\Exception $e) {
            $response = [
                'success' => false,
                'message' => 'Something went wrong. ' . $e->getMessage(),
                'data'    => null,
            ];
        }

        return response()->json([
            'success' => $response['success'],
            'message' => $response['message'],
            'output'  => $response['data'] ?? null,
        ], 200);
    }

    // ==========================================
    // SALARY METHODS
    // ==========================================

    public function createSalary(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'employee_id' => 'required|integer|min:1',
                'basic_salary' => 'required|numeric|min:0',
                'bonus' => 'required|numeric|min:0',
                'deductions' => 'required|numeric|min:0',
                'pay_date' => 'required|date',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => "Validation failed.",
                    'output'  => $validator->errors()->first(),
                ], 422);
            }

            $data = $request->all();
            $out_data = $this->employeeRepository->createSalary($data);
            
            return response()->json([
                'success' => $out_data['success'],
                'message' => $out_data['message'],
                'output'  => $out_data['data'],
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong. ' . $e->getMessage(),
                'output'  => null,
            ], 500);
        }
    }

    public function getAllsalary()
    {
        try {
            $response = $this->employeeRepository->getAllSalaries(); 
            return response()->json([
                'success' => $response['success'],
                'message' => $response['message'],
                'output'  => $response['data'],
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong. ' . $e->getMessage(),
                'output'  => null,
            ], 500);
        }
    }

    public function getSalaryById($id)
    {
        try {
            $response = $this->employeeRepository->getSalaryById($id);
            return response()->json([
                'success' => $response['success'],
                'message' => $response['message'],
                'output'  => $response['data'],
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong. ' . $e->getMessage(),
                'output'  => null,
            ], 500);
        }
    }

    public function updateSalary($id, Request $request)
    {
        try {
            $data = $request->all();
            $response = $this->employeeRepository->updateSalary($id, $data);
            return response()->json([
                'success' => $response['success'],
                'message' => $response['message'],
                'output'  => $response['data'],
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong. ' . $e->getMessage(),
                'output'  => null,
            ], 500);
        }
    }

    public function deleteSalary($id)
    {
        try {
            $response = $this->employeeRepository->deleteSalary($id);
            return response()->json([
                'success' => $response['success'],
                'message' => $response['message'],
                'output'  => $response['data'],
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong. ' . $e->getMessage(),
                'output'  => null,
            ], 500);
        }
    }

    public function createAttendance(Request $request){
        try{
           $validator = Validator::make($request->all(), [
                'employee_id' => 'required|integer|min:1',
                'date'        => 'required|date', 
                'check_in'    => 'required|date_format:H:i:s', 
                'check_out'   => 'required|date_format:H:i:s',
]);

            if($validator->fails()){
                return response()->json([
                    'success' => false,
                    'message' => "Validation failed.",
                    'output'  => $validator->errors()->first(),
                ], 422);
            }

            $data = $request->all();
            $out_data = $this->employeeRepository->createAttendance($data);

            return response()->json([
                'success' => $out_data['success'],
                'message' => $out_data['message'],
                'output'  => $out_data['data'],
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong. ' . $e->getMessage(),
                'output'  => null,
            ], 500);
        }
    }


    public function getAllAttendance(){
        try{
            $response = $this->employeeRepository->getAllAttendances();
            return response()->json([
                'success' => $response['success'],
                'message' => $response['message'],
                'output'  => $response['data'],
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong. ' . $e->getMessage(),
                'output'  => null,
            ], 500);
        }
    }

    public function getAttendanceById($id){
        try{
            $response = $this->employeeRepository->getAttendanceById($id);
            return response()->json([
                'success' => $response['success'],
                'message' => $response['message'],
                'output'  => $response['data'],
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong. ' . $e->getMessage(),
                'output'  => null,
            ], 500);
        }
    }

    public function updateAttendance($id, Request $request){
        try{
            $data = $request->all();
            $response = $this->employeeRepository->updateAttendance($id, $data);
            return response()->json([
                'success' => $response['success'],
                'message' => $response['message'],
                'output'  => $response['data'],
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong. ' . $e->getMessage(),
                'output'  => null,
            ], 500);
        }
    }

    public function deleteAttendance($id){
        try{
            $response = $this->employeeRepository->deleteAttendance($id);
            return response()->json([
                'success' => $response['success'],
                'message' => $response['message'],
                'output'  => $response['data'],
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong. ' . $e->getMessage(),
                'output'  => null,
            ], 500);
        }
    }

    public function ApplyLeave(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'employee_id' => 'required|integer|min:1',
                'leave_date' => 'required|date',
                'leave_type' => 'required|string',
                'status' => 'required|string',
            ]);

            if($validator->fails()){
                return response()->json([
                    'success' => false,
                    'message' => "Validation failed.",
                    'output'  => $validator->errors()->first(),
                ], 422);
            }

            $data = $request->all();
            $out_data = $this->employeeRepository->ApplyLeave($data);

            return response()->json([
                'success' => $out_data['success'],
                'message' => $out_data['message'],
                'output'  => $out_data['data'],
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong. ' . $e->getMessage(),
                'output'  => null,
            ], 500);
        }
    }

    public function getAllLeaves()
    {
        try{
            $response = $this->employeeRepository->getAllLeaves();
            return response()->json([
                'success' => $response['success'],
                'message' => $response['message'],
                'output'  => $response['data'],
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong. ' . $e->getMessage(),
                'output'  => null,
            ], 500);
        }
    }

    public function getLeaveById($id)
    {
        try{
            $response = $this->employeeRepository->getLeaveById($id);
            return response()->json([
                'success' => $response['success'],
                'message' => $response['message'],
                'output'  => $response['data'],
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong. ' . $e->getMessage(),
                'output'  => null,
            ], 500);
        }
    }

    public function updateLeave($id, Request $request)
    {
        try{
            $data = $request->all();
            $response = $this->employeeRepository->updateLeave($id, $data);
            return response()->json([
                'success' => $response['success'],
                'message' => $response['message'],
                'output'  => $response['data'],
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong. ' . $e->getMessage(),
                'output'  => null,
            ], 500);
        }
    }

    public function deleteLeave($id)
    {
        try{
            $response = $this->employeeRepository->deleteLeave($id);
            return response()->json([
                'success' => $response['success'],
                'message' => $response['message'],
                'output'  => $response['data'],
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong. ' . $e->getMessage(),
                'output'  => null,
            ], 500);
        }
    }
}