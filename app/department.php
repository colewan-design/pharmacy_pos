<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class department extends Model
{
     protected $fillable = [ 'departmentId',
                             'departmentName',
                             'departmentDescription',
                             'departmentUse',
                             'departmentIsDeleted',
                             'created_at',
                             'update_at'
                            ];
}
