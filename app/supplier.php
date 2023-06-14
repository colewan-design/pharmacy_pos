<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class supplier extends Model
{
     use SoftDeletes;
     protected $primaryKey="supplierId";
     protected $dates = ['deleted_at'];
     protected $fillable = [ 'supplierId',
                             'supplierName',
                             'supplierDescription',
                             'supplierUse',
                             'created_at',
                             'update_at'
                            ];
}
