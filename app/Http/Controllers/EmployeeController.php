<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Repositories\Interface\EmployeeRepositoryInterface;

class EmployeeController extends Controller
{
    protected $employeeRepository;

    public function __construct(EmployeeRepositoryInterface $employeeRepository)
    {
        $this->employeeRepository = $employeeRepository;
    }

    // ✅ CREATE
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
                $output = [
                    'success' => false,
                    'message' => "Validation failed.",
                    'data'    => $validator->errors()->first(),
                ];
            } else {

                $data = $request->all();
                $out_data = $this->employeeRepository->createEmployee($data);

                $output = [
                    'success' => $out_data['success'],
                    'message' => $out_data['message'],
                    'data'    => $out_data['data'],
                ];
            }

        } catch (\Exception $e) {

            $output = [
                'success' => false,
                'message' => 'Something went wrong. ' . $e->getMessage(),
                'data'    => null,
            ];
        }

        return response()->json([
            'success' => $output['success'],
            'message' => $output['message'],
            'output'  => $output['data'],
        ], 200);
    }


    // ✅ GET ALL
    public function getAllEmployees()
    {
        $response = $this->employeeRepository->getAllEmployees();

        return response()->json([
            'success' => $response['success'],
            'message' => $response['message'],
            'output'  => $response['data'],
        ], 200);
    }


    // ✅ GET BY ID
    public function getEmployeeById($id)
    {
        $response = $this->employeeRepository->getEmployeeById($id);

        return response()->json([
            'success' => $response['success'],
            'message' => $response['message'],
            'output'  => $response['data'],
        ], 200);
    }


    // ✅ UPDATE
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
            'output'  => $response['data'],
        ], 200);
    }


    // ✅ DELETE
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
            'output'  => $response['data'],
        ], 200);
    }

    public function createSalary(Request $request){
        try {

            $validator = Validator::make($request->all(), [
                'employee_id' => 'required|integer|min:1',
                'basic_salary' => 'required|numeric|min:0',
                'bonus' => 'required|numeric|min:0',
                'deductions' => 'required|numeric|min:0',
                'pay_date' => 'required|date',
            ]);

            if($validator->fails()){
                $response = [
                    'success' => false,
                    'message' => "Validation failed.",
                    'data'    => $validator->errors()->first(),
                ];
            }else{
                $data = $request->all();
                $out_data = $this->employeeRepository->createSalary($data);
                $response = [
                    'success' => $out_data['success'],
                    'message' => $out_data['message'],
                    'data'    => $out_data['data'],
                ];
            }
            
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
            'output'  => $response['data'],
        ], 200);
    }

    public function getAllsalary(){
        try {
            $response = $this->employeeRepository->getAllsalary();
            return response()->json([
                'success' => $response['success'],
                'message' => $response['message'],
                'output'  => $response['data'],
            ], 200);
            
        } catch (\Exception $e) {
            $response = [
                'success' => false,
                'message' => 'Something went wrong. ' . $e->getMessage(),
                'data'    => null,
            ];
            return response()->json([
                'success' => $response['success'],
                'message' => $response['message'],
                'output'  => $response['data'],
            ], 200);
        }
    }

    public function getSalaryById($id){
        try {
            $response = $this->employeeRepository->getSalaryById($id);
            return response()->json([
                'success' => $response['success'],
                'message' => $response['message'],
                'output'  => $response['data'],
            ], 200);
            
        } catch (\Exception $e) {
            $response = [
                'success' => false,
                'message' => 'Something went wrong. ' . $e->getMessage(),
                'data'    => null,
            ];
            return response()->json([
                'success' => $response['success'],
                'message' => $response['message'],
                'output'  => $response['data'],
            ], 200);
        }
    }

    public function updateSalary($id, Request $request){
        try {
            $data = $request->all();
            $response = $this->employeeRepository->updateSalary($id, $data);
            return response()->json([
                'success' => $response['success'],
                'message' => $response['message'],
                'output'  => $response['data'],
            ], 200);
            
        } catch (\Exception $e) {
            $response = [
                'success' => false,
                'message' => 'Something went wrong. ' . $e->getMessage(),
                'data'    => null,
            ];
            return response()->json([
                'success' => $response['success'],
                'message' => $response['message'],
                'output'  => $response['data'],
            ], 200);
        }
    }

    public function deleteSalary($id){
        try {
            $response = $this->employeeRepository->deleteSalary($id);
            return response()->json([
                'success' => $response['success'],
                'message' => $response['message'],
                'output'  => $response['data'],
            ], 200);
            
        } catch (\Exception $e) {
            $response = [
                'success' => false,
                'message' => 'Something went wrong. ' . $e->getMessage(),
                'data'    => null,
            ];
            return response()->json([
                'success' => $response['success'],
                'message' => $response['message'],
                'output'  => $response['data'],
            ], 200);
        }
    }
}