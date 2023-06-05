<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class table extends Model
{
    protected $fillable = [ 'tableId',
                            'tableNumber',
                            'tableName',
                            'tableDescription',
                            'tableCapacity',
                            'tableStatus',
                            'tableUse',
                            'created_at',
                            'update_at'
                           ];
}
