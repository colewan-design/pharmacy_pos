<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class expense extends Model
{
    protected $fillable = [ 'expenseId',
                            'accountExpenseId',
                            'expenseAmount',
                            'accountDescription',
                            'expenseDate',
                            'remarks',
                            'userId',
                            'created_at',
                            'update_at'
                            ];
}
