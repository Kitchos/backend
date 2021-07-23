<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    public $timestamps = false;

    protected $fillable = ['name'];

    public function employee()
    {
        return $this->belongsToMany(Employee::class, 'departments_employees', 'department_id', 'employees_id');
    }
}
