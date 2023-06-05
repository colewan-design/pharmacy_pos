<?php
/**
 * Created by PhpStorm.
 * User: khimf
 * Date: 1/28/2021
 * Time: 2:55 PM
 */


namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class categoryCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *s
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => $this->collection
        ];
    }
}
