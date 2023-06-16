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
                             'soldTo',
                             'customerCode',
                             'salesman',
                             'customerType',
                             'date',
                             'address',
                             'poNumber',
                             'salesmanCode',
                             'terms',
                             'page',
                             'productCode',
                             'description',
                             'quantity',
                             'unitPrice',
                             'productDiscount',
                             'amount',
                             'taxCode',
                             'lotNumber',
                             'expiryDate',
                             'split',
                             'order',
                             'delivered',
                             'uom',
                             'unitPriceWOVat',
                             'unitPriceWithVat',
                             'rate',
                             'productDiscountWOVat',
                             'productDiscountWithVat',
                             'amountWithVat',
                             'created_at',
                             'update_at',
                             'deleted_at',
                            ];
}
