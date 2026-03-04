<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;

Route::post('create-employee', [EmployeeController::class, 'createEmployee']);
Route::get('get-all-employees', [EmployeeController::class, 'getAllEmployees']);
Route::get('get-employee-by-id/{id}', [EmployeeController::class, 'getEmployeeById']);
Route::put('update-employee/{id}', [EmployeeController::class, 'updateEmployee']);
Route::delete('delete-employee/{id}', [EmployeeController::class, 'deleteEmployee']);