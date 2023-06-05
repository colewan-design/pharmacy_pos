<?php
/**
 * Created by PhpStorm.
 * User: khimf
 * Date: 1/28/2021
 * Time: 2:53 PM
 */


namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class cashout extends JsonResource
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
            'cashOutId' => $this->cashOutId,
            'cashoutUserId'=> $this->cashoutUserId,
            'receiveBy' =>$this->receiveBy,
            'amount' =>$this->amount,
            'note' =>$this->note,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

        ];
//        return parent::toArray($request);
    }
}
