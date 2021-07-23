<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    public $timestamps = false;

    protected $fillable = ['id','first_name', 'surname', 'patronymic', 'sex', 'wage'];

    public function department()
    {
        return $this->belongsToMany(Department::class, 'departments_employees', 'employees_id');
    }
}
