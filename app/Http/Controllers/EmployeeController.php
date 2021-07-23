<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Http\Controllers\Controller;
use App\UseCases\EmployeeService;
use App\Http\Resources\Employee\EmployeeResourceCollection;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class EmployeeController extends Controller
{
    private $employeeService;

    public function __construct(EmployeeService $employeeService)
    {
        $this->employeeService = $employeeService;
    }

    public function index()
    {
        return formattedResponseApi(function () {

            $employees = Employee::paginate();
            return new EmployeeResourceCollection($employees);
        });
    }

    public function store(Request $request)
    {
        return formattedResponseApi(function () use ($request) {
            $this->validate($request, [
                'first_name' => 'required|string',
                'surname' => 'required|string',
                'patronymic' => 'required|string',
                'sex' => 'nullable|string',
                'wage' => 'required|integer',
                'department_ids' => 'required|array',
                'department_ids.*' => 'required|integer',
            ]);
//            return $this->employeeService->create($request);
            if($this->employeeService->create($request)){
                return 'Сотрудник успешно добавлен!';
            }else{
                throw new BadRequestHttpException('Ошибочка!');
            }
        });
    }

    public function update($id ,Request $request)
    {
        return formattedResponseApi(function () use ($id, $request) {

            $employee = Employee::find($id);
            if($employee) {
                $this->validate($request, [
                    'first_name' => 'required|string',
                    'surname' => 'required|string',
                    'patronymic' => 'required|string',
                    'sex' => 'nullable|string',
                    'wage' => 'required|integer',
                    'department_ids' => 'required|array',
                    'department_ids.*' => 'required|integer',
                ]);
                if($this->employeeService->update($employee, $request)){
                    return 'Сотрудник успешно изменен!';
                }else{
                    throw new BadRequestHttpException('Ошибочка!');
                }
            }
            throw new BadRequestHttpException('Данного сотрудника не существует!');
        });
    }

    public function destroy($id)
    {
        return formattedResponseApi(function () use ($id) {

            $employee = Employee::find($id);
            if ($employee) {
                if ($employee->delete()) {
                    return 'Сотрудник успешно удален!';
                } else {
                    throw new BadRequestHttpException('Ошибочка!');
                }
            }
            throw new BadRequestHttpException('Данного сотрудника не существует!');
        });
    }
}
