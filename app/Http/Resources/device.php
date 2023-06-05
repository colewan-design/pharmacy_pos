<?php
/**
 * Created by PhpStorm.
 * User: khimf
 * Date: 1/28/2021
 * Time: 2:56 PM
 */

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class device extends JsonResource
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
            'deviceId' => $this->deviceId,
            'departmentId' =>$this->departmentId,
            'deviceName' =>$this->deviceName,
            'deviceDescription' =>$this->deviceDescription,
            'deviceUse' =>$this->deviceUse,
            'deviceIsDeleted' =>$this->deviceIsDeleted,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

        ];
//        return parent::toArray($request);
    }
}
