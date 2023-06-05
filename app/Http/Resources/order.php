<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class order extends JsonResource
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
            'orderId' => $this->orderId,
            'transactionId' => $this->transactionId,
            'itemId' =>$this->itemId,
            'categoryId' =>$this->categoryId,
            'orderQty' =>$this->orderQty,
            'orderPrice' =>$this->orderPrice,
            'orderTotal' =>$this->orderTotal,
            // 'orderServed' =>$this->orderServed,
            'itemNote' =>$this->itemNote,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

        ];
//        return parent::toArray($request);
    }
}
