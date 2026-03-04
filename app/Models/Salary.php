<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Salary extends Model
{
    use HasFactory;

    protected $table = 'salaries';

    protected $fillable = [
        'employee_id',
        'basic_salary',
        'bonus',
        'deductions',
        'pay_date'
    ];

    protected $casts = [
         'id' => 'integer',
        'employee_id' => 'integer',
        'basic_salary' => 'decimal:2',
        'bonus' => 'decimal:2',
        'deductions' => 'decimal:2',
        'pay_date' => 'date'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

   public function getNetSalaryAttribute()
    {
        return $this->basic_salary + $this->bonus - $this->deductions;
    }
}
