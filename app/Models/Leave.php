<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Leave extends Model
{
 use HasFactory;

 protected $table = 'leaves';
 protected $fillable = [
    'employee_id',
    'leave_date',
    'leave_type',
    'status',
 ];

 protected $casts = [
    'employee_id' => 'integer',
    'leave_date' => 'date',
    'leave_type' => 'string',
    'status' => 'string',
 ];

 public function employee()
 {
    return $this->belongsTo(Employee::class);
 }
}
