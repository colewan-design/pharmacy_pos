<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class order extends Model
{
    protected $fillable = [ 'orderId',
                            'transactionId',
                            'itemId',
                            'categoryId',
                            'orderQty',
                            'orderPrice',
                            'orderTotal',
                            'orderStatus',
                            'orderServed',
                            'itemNote',
                            'created_at',
                            'update_at'
                           ];

    // public function items() {
    //     return $this->hasMany(item::class, 'itemId');
    // }
}
