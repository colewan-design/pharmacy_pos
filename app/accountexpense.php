<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class accountexpense extends Model
{
    protected $fillable = [ 'accountExpenseId',
                            'accountCode',
                            'accountDescription',
                            'created_at',
                            'update_at'
                            ];
}
