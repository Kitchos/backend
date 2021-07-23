<?php

namespace App\Http\Resources\Department;

use Illuminate\Http\Resources\Json\ResourceCollection;

class DepartmentResourceCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function toArray($request)
    {
        return $this->collection->map(function ($item) {
            return [
                'id' => $item->id,
                'name' => $item->name,
                'count_employees' => $item->employee->count(),
                'max_wage' => $item->employee->max('wage'),
            ];
        });
    }
}
