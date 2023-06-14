<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class purchaseOrder extends Model
{
     use SoftDeletes;
     protected $primaryKey="purchaseOrderId";
     protected $dates = ['deleted_at'];
     protected $fillable = [ 'purchaseOrderId',
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
