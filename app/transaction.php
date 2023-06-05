<?php
/**
 * Created by PhpStorm.
 * User: khimf
 * Date: 1/29/2021
 * Time: 11:37 AM
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class transaction extends Model
{
    protected $fillable = [ 'transactionId',
                            'transactionUserId',
                            'transactionNote',
                            'transactionSlipNo',
                            'transactionTableId',
                            'transactionServedBy',
                            'transactionStatus',
                            'transactionKitchenStatus',
                            'transactionBarStatus',
                            'transactionOutsourcedStatus',
                            'created_at',
                            'update_at'
                           ];
}
