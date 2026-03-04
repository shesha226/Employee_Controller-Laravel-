<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model
{

    use HasFactory;

    protected $table = 'employees';

    protected $fillable = [
        'name',
        'email',
        'address',
        'phone',
        'age',
        'gender',
        'dob',
        'join_date',
        'department',
        'position',
        'salary',
        'status',
    ];

    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'email' => 'string',
        'address' => 'string',
        'phone' => 'string',
        'age' => 'integer',
        'gender' => 'string',
        'dob' => 'date',
        'join_date' => 'date',
        'department' => 'string',
        'position' => 'string',
        'salary' => 'string',
        'status' => 'string',
    ];
}
