<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class payment extends JsonResource
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
            'paymentId' => $this->paymentId,
            'transactionId' => $this->transactionId,
            'customer' =>$this->customer,
            'discount'=>$this->discount,
            'totalAmount' =>$this->totalAmount,
            'tenderedAmount' =>$this->tenderedAmount,
            'change' =>$this->change,
            'accountReceivableAmount'=>$this->accountReceivableAmount,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

        ];
//        return parent::toArray($request);
    }
}
