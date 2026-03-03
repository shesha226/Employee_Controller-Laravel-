<?php

namespace App\Repositories\Interface;

interface EmployeeRepositoryInterface
{
    public function createEmployee(array $data);
    public function getAllEmployees();
    public function getEmployeeById($id);
    public function updateEmployee($id, array $data);
    public function deleteEmployee($id);
}