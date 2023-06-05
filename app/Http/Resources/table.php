<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class table extends JsonResource
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
            'tableId' => $this->tableId,
            'tableNumber' => $this->tableNumber,
            'tableName' =>$this->tableName,
            'tableDescription' =>$this->tableDescription,
            'tableCapacity' =>$this->tableCapacity,
            'tableStatus' =>$this->tableStatus,
            'tableUse' =>$this->tableUse,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

        ];
//        return parent::toArray($request);
    }
}
