<?php

namespace App\Http\Controllers;

use App\Http\Resources\Department\DepartmentResourceCollection;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use App\Models\Department;
use App\UseCases\DepartmentService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DepartmentController extends Controller
{

    /**
     * @var DepartmentService
     */
    private $departmentService;

    public function __construct(DepartmentService $departmentService)
    {
        $this->departmentService = $departmentService;
    }

    public function index()
    {
        return formattedResponseApi(function () {

            $employees = Department::paginate();
            return new DepartmentResourceCollection($employees);
        });
    }

    public function store(Request $request)
    {
        return formattedResponseApi(function () use ($request) {
            $this->validate($request, [
                'name' => 'required|string',
            ]);
            if($this->departmentService->create($request)){
                return 'Отдел успешно добавлен!';
            }else{
                throw new BadRequestHttpException('Ошибочка!');
            }
        });
    }

    public function update($id ,Request $request)
    {
        return formattedResponseApi(function () use ($id, $request) {

            $department = Department::find($id);
            if($department) {
                $this->validate($request, [
                    'name' => 'required|string',
                ]);
                if($this->departmentService->update($department, $request)){
                    return 'Отдел успешно изменен!';
                }else{
                    throw new BadRequestHttpException('Ошибочка!');
                }
            }
            throw new BadRequestHttpException('Отдел не существует!');
        });
    }

    public function destroy($id)
    {
        return formattedResponseApi(function () use ($id) {

            $department = Department::find($id);
            //можно добаввить doesntHave('employee') но тогда ошибку не существования и присудствия сотрудников нужно объеденить
            // и не нужно будет проверять количество записей
            if ($department) {
                if($department->employee->count() <= 0) {
                    if ($department->delete()) {
                        return 'Отдел успешно удален!';
                    } else {
                        throw new BadRequestHttpException('Ошибочка!');
                    }
                }else{
                    throw new BadRequestHttpException('Не возможно удалить отдел т.к. есть сотрудники!');
                }
            }
            throw new BadRequestHttpException('Отдел не существует!');
        });
    }

}
