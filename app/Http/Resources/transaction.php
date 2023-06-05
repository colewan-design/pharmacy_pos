<?php
/**
 * Created by PhpStorm.
 * User: khimf
 * Date: 1/28/2021
 * Time: 2:56 PM
 */

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class transaction extends JsonResource
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
            'transactionId' => $this->transactionId,
            'transactionUserId'=>$this->transactionUserId,
            'transactionSlipNo' =>$this->transactionSlipNo,
            'transactionTableId' =>$this->transactionTableId,
            'transactionServedBy' =>$this->transactionServedBy,
            'transactionStatus' =>$this->transactionStatus,
            'transactionKitchenStatus' =>$this->transactionKitchenStatus,
            'transactionBarStatus' =>$this->transactionBarStatus,
            'transactionOutsourcedStatus' =>$this->transactionOutsourcedStatus,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

        ];
//        return parent::toArray($request);
    }
}
