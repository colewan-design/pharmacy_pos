<?php
/**
 * Created by PhpStorm.
 * User: khimf
 * Date: 1/28/2021
 * Time: 2:56 PM
 */

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class item extends JsonResource
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
            'itemId' => $this->itemId,
            'categoryId' =>$this->categoryId,
            'itemName' =>$this->itemName,
            'itemDescription' =>$this->itemDescription,
            'itemQty' =>$this->itemQty,
            'itemPrice' =>$this->itemPrice,
            'itemUse' =>$this->itemUse,
            'itemIsDeleted' =>$this->itemIsDeleted,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

        ];
//        return parent::toArray($request);
    }
}
