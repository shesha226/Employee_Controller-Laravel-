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

    //Attendance
    public function createAttendance(array $data);
    public function getAllAttendances();
    public function getAttendanceById($id);
    public function updateAttendance($id, array $data);
    public function deleteAttendance($id);

    //Leaves
    public function ApplyLeave(array $data);
    public function getAllLeaves();
    public function getLeaveById($id);
    public function updateLeave($id, array $data);
    public function deleteLeave($id);
}