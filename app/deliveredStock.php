<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class deliveredStock extends Model
{
     use SoftDeletes;
     protected $primaryKey="deliveredStockId";
     protected $dates = ['deleted_at'];
     protected $fillable = [ 'deliveredStockId',
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
