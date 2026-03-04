<?php

namespace App\Repositories\Interfaces;

interface EmployeeRepositoryInterface
{
    // Employee
    public function createEmployee(array $data);
    public function getAllEmployees();
    public function getEmployeeById($id);
    public function updateEmployee($id, array $data);
    public function deleteEmployee($id);

    // Salary
    public function createSalary(array $data);
    public function getAllSalaries();
    public function getSalaryById($id);
    public function updateSalary($id, array $data);
    public function deleteSalary($id);
}