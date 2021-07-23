<?php


namespace App\UseCases;


use App\Models\Employee;
use App\Models\Department;
use Illuminate\Http\Request;
use DB;

class EmployeeService
{

    public function create(Request $request)
    {
//        Employee::create([
        $employee = Employee::make([
            'first_name' => $request->first_name,
            'surname' => $request->surname,
            'patronymic' => $request->patronymic,
            'sex' => $request->sex,
            'wage' => $request->wage
        ]);

        if($employee->saveOrfail()) {
            if ($request->department_ids) {
                foreach ($request->department_ids as $department_id) {
                    $department = Department::findOrFail($department_id);
                    $employee->department()->attach($department->id);
                }
            }
            return true;
        }else{
            return false;
        }
    }

    public function update(Employee $employee, Request $request)
    {
        $employee->fill([
            'first_name' => $request->first_name,
            'surname' => $request->surname,
            'patronymic' => $request->patronymic,
            'sex' => $request->sex,
            'wage' => $request->wage
        ]);


        if($employee->saveOrFail()) {
            DB::table('departments_employees')->where('employees_id', $employee->id)->delete();
            if ($request->department_ids) {
                foreach ($request->department_ids as $department_id) {
                    $department = Department::findOrFail($department_id);
                    $employee->department()->attach($department->id);
                }
            }
            return true;
        }else{
            return false;
        }
    }
}
