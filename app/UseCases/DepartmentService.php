<?php


namespace App\UseCases;


use App\Models\Employee;
use App\Models\Department;
use Illuminate\Http\Request;
use DB;

class DepartmentService
{

    public function create(Request $request)
    {
//        Employee::create([
        $department = Department::make([
            'name' => $request->name,
        ]);

        if($department->saveOrfail()) {
            return true;
        }else{
            return false;
        }
    }

    public function update(Department $department, Request $request)
    {
        $department->fill([
            'name' => $request->name,
        ]);

        if($department->saveOrFail()) {
            return true;
        }else{
            return false;
        }
    }
}
