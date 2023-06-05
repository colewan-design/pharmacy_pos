<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class payment extends Model
{
    protected $fillable = [ 'paymentId',
                            'transactionId',
                            'customer',
                            'discount',
                            'totalAmount',
                            'tenderedAmount',
                            'change',
                            'accountReceivableAmount',
                            'created_at',
                            'update_at'
                           ];
}
