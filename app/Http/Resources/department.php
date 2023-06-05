<?php
/**
 *Created by PhpStorm.
 * User: khimf
* Date: 1/28/2021
* Time: 12:05 PM
*/



namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class department extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'departmentId' => $this->departmentId,
            'departmentName' =>$this->departmentName,
            'departmentDescription' =>$this->departmentDescription,
            'departmentUse' =>$this->departmentUse,
            'categoryIsDeleted' =>$this->categoryIsDeleted,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

        ];
//        return parent::toArray($request);
    }
}

