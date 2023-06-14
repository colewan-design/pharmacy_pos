<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class badOrder extends Model
{
     use SoftDeletes;
     protected $primaryKey="badOrderId";
     protected $dates = ['deleted_at'];
     protected $fillable = [ 'badOrderId',
                            'purchaseOrderId',
                             'supplierName',
                             'itemName',
                             'itemDescription',
                             'itemQty',
                             'fromLocation',
                             'created_at',
                             'update_at',
                             'deleted_at'
                            ];
}
