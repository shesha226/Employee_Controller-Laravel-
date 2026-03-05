<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController; 

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Employee API Routes
Route::post('/create-employee', [EmployeeController::class, 'createEmployee']);
Route::get('/get-all-employees', [EmployeeController::class, 'getAllEmployees']);
Route::get('/get-employee-by-id/{id}', [EmployeeController::class, 'getEmployeeById']);
Route::put('/update-employee/{id}', [EmployeeController::class, 'updateEmployee']);
Route::delete('/delete-employee/{id}', [EmployeeController::class, 'deleteEmployee']);

// Salary API Routes
Route::post('/create-salary', [EmployeeController::class, 'createSalary']);
Route::get('/get-all-salaries', [EmployeeController::class, 'getAllsalary']);
Route::get('/get-salary-by-id/{id}', [EmployeeController::class, 'getSalaryById']);
Route::put('/update-salary/{id}', [EmployeeController::class, 'updateSalary']);
Route::delete('/delete-salary/{id}', [EmployeeController::class, 'deleteSalary']);

//Attendance API Routes
Route::post('/create-attendance', [EmployeeController::class, 'createAttendance']);
Route::get('/get-all-attendance', [EmployeeController::class, 'getAllAttendance']);
Route::get('/get-attendance-by-id/{id}', [EmployeeController::class, 'getAttendanceById']);
Route::put('/update-attendance/{id}', [EmployeeController::class, 'updateAttendance']);
Route::delete('/delete-attendance/{id}', [EmployeeController::class, 'deleteAttendance']);

//Leave API Routes
Route::post('/apply-leave', [EmployeeController::class, 'ApplyLeave']);
Route::get('/get-all-leaves', [EmployeeController::class, 'getAllLeaves']);
Route::get('/get-leave-by-id/{id}', [EmployeeController::class, 'getLeaveById']);
Route::put('/update-leave/{id}', [EmployeeController::class, 'updateLeave']);
Route::delete('/delete-leave/{id}', [EmployeeController::class, 'deleteLeave']);