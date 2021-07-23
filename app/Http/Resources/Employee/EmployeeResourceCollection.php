<?php

namespace App\Http\Resources\Employee;

use Illuminate\Http\Resources\Json\ResourceCollection;

class EmployeeResourceCollection extends ResourceCollection
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
                'FIO' => $item->surname.' '.$item->first_name.' '.$item->patronymic,
                'sex' => $item->sex,
                'wage' => $item->wage,
            ];
        });
    }
}
